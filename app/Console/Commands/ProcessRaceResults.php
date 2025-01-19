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
        // Intentar extraer num_carrera y etapa si está presente
        if (preg_match('/^(\d+).*Etapa\s(\d+)/i', $fileName, $matches)) {
            return [(int)$matches[1], (int)$matches[2]];
        }

        // Si no se encuentra "Etapa", es una clásica: solo extraer num_carrera
        if (preg_match('/^(\d+)\s/i', $fileName, $matches)) {
            return [(int)$matches[1], 1]; // Asumir etapa = 1
        }

        // Si no se puede extraer, retornar valores nulos
        return [null, null];
    }

private function processRaceFile($spreadsheet, $numCarrera, $etapa)
{
    $carrera = Carrera::where('num_carrera', $numCarrera)
        ->where('temporada', config('tcm.temporada'))
        ->first(['categoria', 'tipo', 'num_etapas']);

    if (!$carrera) {
        $this->error("No se encontró la carrera con num_carrera: $numCarrera");
        return;
    }

    // Determinar si es la última etapa
    $isLastStage = $etapa == $carrera->num_etapas;

    // Clasificaciones a procesar según la etapa
    $classificationsToProcess = $isLastStage
        ? ['etapa', 'general', 'gene-reg', 'gene-mon', 'gene-jov', 'gene-equi']
        : ['etapa', 'provi-gene', 'provi-reg', 'provi-mon', 'provi-jov'];

    // Configuración de puntos
    $pointsConfig = DB::table('puntos')
        ->where('temporada', config('tcm.temporada'))
        ->where('categoria', $carrera->categoria)
        ->where('tipo', $carrera->tipo)
        ->whereIn('clasificacion', $classificationsToProcess)
        ->get()
        ->groupBy(fn($item) => "{$item->clasificacion}_{$item->posicion}");

    // Categorías en el Excel y sus campos en la BD
    $categories = [
        'Stage results' => 'posicion',
        'General results' => 'pos_gral',
        'Points' => 'gral_reg',
        'Mountain' => 'gral_mon',
        'Young results' => 'gral_jov',
    ];

    $results = [];

    // Procesar la pestaña "Team results" en la última etapa y encontrar el equipo ganador.
if ($etapa > 1 && $isLastStage) {
    $teamSheet = $spreadsheet->getSheetByName('Team results');
    if ($teamSheet) {
        $highestRow = $teamSheet->getHighestRow();

        // Validar si la pestaña tiene datos
        if ($highestRow > 1) {
            $teamName = null;

            // Iterar sobre las filas de la pestaña
            foreach ($teamSheet->getRowIterator(2) as $row) {
                $positionRaw = $teamSheet->getCell("D{$row->getRowIndex()}")->getValue();

                // Extraer el valor entre paréntesis
                if ($positionRaw && preg_match('/\((\d+)\)/', $positionRaw, $matches)) {
                    $position = (int)$matches[1];
                    if ($position === 1) {
                        $teamName = $teamSheet->getCell("B{$row->getRowIndex()}")->getValue();
                        break; // Salir del bucle después de encontrar el equipo ganador
                    }
                }
            }

            if ($teamName) {
                // Obtener el cod_equipo desde la tabla equipos
                $winnerTeam = DB::table('equipos')->where('nombre_en_bd', $teamName)->first();
                $this->info("Equipo ganador: $teamName cod_equpo: $winnerTeam->cod_equipo");
                if ($winnerTeam) {
                    // Buscar puntos para gene-equi en la primera posición
                    $key = "gene-equi_1";
                    $winnerTeamPoints = isset($pointsConfig[$key]) ? $pointsConfig[$key]->first()->pts : 0;
                } else {
                    $this->warn("Equipo no encontrado en la BD: $teamName");
                }
            } else {
                $this->warn("No se encontró ningún equipo con posición 1 en la columna 'D'.");
            }
        } else {
            $this->warn("La pestaña 'Team results' no tiene datos.");
        }
    } else {
        $this->warn("No se encontró la pestaña 'Team results'.");
    }
}

    foreach ($categories as $category => $dbField) {
        $sheet = $spreadsheet->getSheetByName($category);

        if (!$sheet) {
            $this->warn("No se encontró la pestaña '$category'. Se omite.");
            continue;
        }

        $highestRow = $sheet->getHighestRow();

        // Validar si la pestaña tiene datos (más de una fila)
        if ($highestRow <= 1) {
            $this->warn("La pestaña '$category' no tiene datos. Se omite.");
            continue;
        }

        foreach ($sheet->getRowIterator(2) as $row) {
            $rank = null; // Inicializar la variable
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();

            if ($category === 'Young results') {
                // Extraer el valor dentro de paréntesis de la columna `E`
                $posRealRaw = $sheet->getCell("E{$row->getRowIndex()}")->getValue();
                if ($posRealRaw && preg_match('/\((\d+)\)/', $posRealRaw, $matches)) {
                    $rank = (int)$matches[1];
                }
            } else {
                // Para las demás categorías, extraer el rango de la columna `A`
                $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
            }

            if (!$rank || !$name) {
                continue;
            }

            $ciclista = Ciclista::where('nom_ape', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            if (!isset($results[$ciclista->cod_ciclista])) {
                $results[$ciclista->cod_ciclista] = [
                    'positions' => [
                        'cod_equipo' => $ciclista->cod_equipo,
                        'posicion' => null,
                        'pos_gral' => null,
                        'gral_reg' => null,
                        'gral_mon' => null,
                        'gral_jov' => null,
                    ],
                    'points' => 0,
                ];
            }

            $results[$ciclista->cod_ciclista]['positions'][$dbField] = $rank;

            if (isset($winnerTeam) && $category === 'General results' && $ciclista->cod_equipo == $winnerTeam->cod_equipo && $etapa > 1 && $isLastStage) {
                $results[$ciclista->cod_ciclista]['points'] += $winnerTeamPoints;
            }


            // Determinar clasificación y puntos a sumar
            $classification = $this->getClassification($category, $isLastStage);
            if ($classification) {
                $key = "{$classification}_{$rank}";
                $points = isset($pointsConfig[$key]) ? $pointsConfig[$key]->first()->pts : 0;
                $results[$ciclista->cod_ciclista]['points'] += $points;
            }
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

    // Actualizar resultados en la BD
    DB::table('resultados')->upsert(
        $toUpdate,
        ['temporada', 'num_carrera', 'etapa', 'cod_ciclista'],
        [
            'pts',
            'cod_equipo',
            'posicion',
            'pos_gral',
            'gral_reg',
            'gral_mon',
            'gral_jov',
            'updated_at',
        ]
    );

    $this->info("Resultados procesados y almacenados para Carrera: $numCarrera, Etapa: $etapa.");
}




    private function getClassification($category, $isLastStage)
    {
        return match ($category) {
            'Stage results' => 'etapa',
            'General results' => $isLastStage ? 'general' : 'provi-gene',
            'Points' => $isLastStage ? 'gene-reg' : 'provi-reg',
            'Mountain' => $isLastStage ? 'gene-mon' : 'provi-mon',
            'Young results' => $isLastStage ? 'gene-jov' : 'provi-jov',
            default => null,
        };
    }


}
