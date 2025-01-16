<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Resultado;
use App\Models\Ciclista;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessRaceResults extends Command
{
    protected $signature = 'process:race-results {folder} {file?}';
    protected $description = 'Procesa archivos .xlsx de resultados de una carpeta o un archivo específico.';

    public function handle()
    {
        // Obtener los parámetros
        $folder = $this->argument('folder');
        $file = $this->argument('file');

        // Directorio base para los archivos
        $importDir = storage_path("app/imports/resultados/$folder");

        // Verificar si la carpeta existe
        if (!is_dir($importDir)) {
            $this->error("El directorio $importDir no existe.");
            return Command::FAILURE;
        }

        // Obtener los archivos a procesar
        $files = $file ? [$importDir . DIRECTORY_SEPARATOR . $file] : glob($importDir . DIRECTORY_SEPARATOR . '*.xlsx');

        if (empty($files)) {
            $this->warn("No se encontraron archivos .xlsx en el directorio: $importDir");
            return Command::FAILURE;
        }

        foreach ($files as $filePath) {
            $this->info("Procesando archivo: $filePath");

            if (!file_exists($filePath)) {
                $this->warn("El archivo $filePath no existe. Se omite.");
                continue;
            }

            try {
                $spreadsheet = IOFactory::load($filePath);
                $fileNameWithoutExt = pathinfo($filePath, PATHINFO_FILENAME);
                [$numCarrera, $etapa] = $this->extractRaceAndStage($fileNameWithoutExt);

                if (!$numCarrera || !$etapa) {
                    $this->error("No se pudo determinar num_carrera y etapa del archivo: $filePath");
                    continue;
                }

                $this->info("Carrera ID: $numCarrera, Etapa: $etapa");

                $this->processRaceFile($spreadsheet, $numCarrera, $etapa);

                $this->info("Archivo procesado exitosamente: $filePath");
            } catch (\Exception $e) {
                $this->error("Error al procesar el archivo $filePath: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }

    private function extractRaceAndStage(string $fileName): array
    {
        preg_match('/^(\d+).*Etapa\s(\d+)/i', $fileName, $matches);
        return [(int)($matches[1] ?? null), (int)($matches[2] ?? 1)];
    }

    private function processRaceFile($spreadsheet, $numCarrera, $etapa)
    {
        $carrera = Carrera::where('num_carrera', $numCarrera)
            ->where('temporada', config('tcm.temporada'))
            ->first(['categoria', 'tipo', 'num_etapas']); // Obtener categoría y tipo de la carrera

        if (!$carrera) {
            $this->error("No se encontró la carrera con num_carrera: $numCarrera");
            return;
        }

        // Determinar si es la última etapa
        $isLastStage = $etapa == $carrera->num_etapas;
        $isSingleStage = $carrera->num_etapas == 1;

        // Configuración de puntos: Clasificaciones a procesar
        $classificationsToProcess = $isLastStage 
            ? ($isSingleStage ? ['etapa'] : ['etapa', 'gene-reg', 'gene-mon', 'gene-jov', 'gene-equi']) 
            : ['etapa', 'provi-gene', 'provi-reg', 'provi-mon', 'provi-jov'];

        // Configuración de puntos por posición y clasificación
        $pointsConfig = DB::table('puntos')
            ->where('temporada', config('tcm.temporada'))
            ->where('categoria', $carrera->categoria) // Filtrar por categoría (U24, WT, Conti...)
            ->where('tipo', $carrera->tipo) // Filtrar por tipo (GV, Vuelta, Clasica...)
            ->whereIn('clasificacion', $classificationsToProcess)
            ->get()
            ->groupBy(fn($item) => "{$item->clasificacion}_{$item->posicion}");

        // Categorías a procesar (para campos en la tabla resultados)
        $categories = [
            'Stage results' => 'posicion',
            'Points' => 'gral_reg',
            'Mountain' => 'gral_mon',
            'Young results' => 'gral_jov',
        ];

        $results = [];

        
        foreach ($categories as $category => $dbField) {
            $sheet = $spreadsheet->getSheetByName($category);

            if (!$sheet) {
                $this->warn("No se encontró la pestaña '$category'.");
                continue;
            }

            foreach ($sheet->getRowIterator(2) as $row) {
                $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
                $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();

                if (!$rank || !$name) {
                    continue; // Saltar filas incompletas
                }

                $ciclista = Ciclista::where('nom_ape', $name)->first();

                if (!$ciclista) {
                    $this->warn("Ciclista no encontrado: $name");
                    continue;
                }

                // Usar la nueva función
                $key = $this->mapCategoryToClasificacion($category, $isLastStage, $isSingleStage) . "_{$rank}";
                $points = isset($pointsConfig[$key]) ? $pointsConfig[$key]->first()->pts : 0;
                if ($ciclista->cod_ciclista == 7051){
                            $this->info("$name-- $key: $points");
                }

                if (!isset($results[$ciclista->cod_ciclista])) {
                    $results[$ciclista->cod_ciclista] = [
                        'positions' => [
                            'posicion' => null,
                            'gral_reg' => null,
                            'gral_mon' => null,
                            'gral_jov' => null,
                        ],
                        'points' => 0,
                    ];
                }

                $results[$ciclista->cod_ciclista]['positions'][$dbField] = $rank;
                $results[$ciclista->cod_ciclista]['points'] += $points;
            }
        }


        $toUpdate = [];
        foreach ($results as $codCiclista => $data) {
            $toUpdate[] = array_merge(
                [
                    'temporada' => config('tcm.temporada'),
                    'num_carrera' => $numCarrera,
                    'etapa' => $etapa,
                    'cod_ciclista' => $codCiclista,
                    'pts' => $data['points'],
                ],
                $data['positions']
            );
        }

        // Realizar el upsert acumulando los puntos después de cada etapa
        DB::table('resultados')->upsert(
            $toUpdate,
            ['temporada', 'num_carrera', 'etapa', 'cod_ciclista'],
            [
                'pts' => DB::raw('COALESCE(resultados.pts, 0) + excluded.pts'),
                'posicion',
                'gral_reg',
                'gral_mon',
                'gral_jov',
                'updated_at',
            ]
        );

        $this->info("Resultados procesados y almacenados para Carrera: $numCarrera, Etapa: $etapa.");
    }


    private function mapCategoryToClasificacion($category, $isLastStage, $isSingleStage)
    {
        return match ($category) {
            'Stage results' => 'etapa', // Siempre es 'etapa'
            'Points' => $isLastStage ? 'gene-reg' : 'provi-reg',
            'Mountain' => $isLastStage ? 'gene-mon' : 'provi-mon',
            'Young results' => $isLastStage ? 'gene-jov' : 'provi-jov',
            default => null,
        };
    }

}
