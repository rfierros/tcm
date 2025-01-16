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
    protected $signature = 'process:race-results {file}';
    protected $description = 'Procesa un archivo .xlsx de resultados y actualiza la tabla resultados.';

    public function handle()
    {
        // Directorio donde se almacenan los archivos
        $importDir = storage_path('app/imports/resultados');

        // Obtener el nombre del archivo desde el parámetro
        $fileName = $this->argument('file');

        // Construir la ruta completa del archivo
        $filePath = $importDir . DIRECTORY_SEPARATOR . $fileName;

        // Verificar si el archivo existe
        if (!file_exists($filePath)) {
            $this->error("El archivo $filePath no existe.");
            return Command::FAILURE;
        }

        $this->info("Procesando archivo: $filePath");

        try {
            // Abrir el archivo
            $spreadsheet = IOFactory::load($filePath);

            // Determinar carrera y etapa
            $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
            [$numCarrera, $etapa] = $this->extractRaceAndStage($fileNameWithoutExt);

            if (!$numCarrera || !$etapa) {
                $this->error("No se pudo determinar num_carrera y etapa del archivo: $fileName");
                return Command::FAILURE;
            }

            $this->info("Carrera ID: $numCarrera, Etapa: $etapa");

            // Procesar las pestañas del archivo
            $this->processStageResults($spreadsheet, $numCarrera, $etapa);
            $this->processGeneralResults($spreadsheet, $numCarrera, $etapa);
            $this->processPointsResults($spreadsheet, $numCarrera, $etapa);
            $this->processMountainResults($spreadsheet, $numCarrera, $etapa);
            $this->processYoungResults($spreadsheet, $numCarrera, $etapa);
            // $this->processTeamResults($spreadsheet, $numCarrera, $etapa);

            $this->info("Archivo procesado exitosamente.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error al procesar el archivo: " . $e->getMessage());
            return Command::FAILURE;
        }
    }


    private function extractRaceAndStage(string $fileName): array
    {
        // Mejor expresión regular para extraer num_carrera y etapa
        //preg_match('/^(\d+).*(?:Etapa\s(\d+))?/i', $fileName, $matches);
        preg_match('/^(\d+).*Etapa\s(\d+)/i', $fileName, $matches);

        // Debugging opcional para verificar los valores capturados
        $this->warn("Var valor 0: " . ($matches[0] ?? 'No encontrado'));
        $this->warn("Var valor 1: " . ($matches[1] ?? 'No encontrado'));
        $this->warn("Var valor 2: " . ($matches[2] ?? 'No encontrado'));

        // Capturar num_carrera y etapa
        $numCarrera = $matches[1] ?? null;
        $etapa = isset($matches[2]) ? (int)$matches[2] : 1; // Por defecto, etapa = 1 si no está especificada

        return [(int)$numCarrera, $etapa];
    }

    private function processStageResults($spreadsheet, $numCarrera, $etapa)
    {
        $sheet = $spreadsheet->getSheetByName('Stage results');

        if (!$sheet) {
            $this->warn("No se encontró la pestaña 'Stage results'.");
            return;
        }

        // Recuperar información de la carrera para determinar categoría y tipo
        $carrera = Carrera::where('num_carrera', $numCarrera)
            ->where('temporada', config('tcm.temporada'))
            ->first(['categoria', 'tipo', 'num_etapas']); // Incluir 'num_etapas'

        if (!$carrera) {
            $this->error("No se encontró la carrera con num_carrera: $numCarrera");
            return;
        }

        foreach ($sheet->getRowIterator(2) as $row) { // Asume encabezados en la fila 1.
            $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();
            $time = $sheet->getCell("D{$row->getRowIndex()}")->getValue();

            if (!$rank || !$name) {
                continue; // Salta filas incompletas.
            }

            $ciclista = Ciclista::where('nom_ape', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            // Obtener los puntos para la posición en esta etapa
            $puntos = DB::table('puntos')
                ->where('temporada', config('tcm.temporada'))
                ->where('posicion', $rank)
                ->where('categoria', $carrera->categoria)
                ->where('tipo', $carrera->tipo)
                ->where('clasificacion', 'etapa')
                ->value('pts'); // Recupera directamente el valor de 'pts'

            if (is_null($puntos)) {
                $puntos = 0; // Si no hay puntos definidos para esta posición, se asignan 0
            }

            // Actualizar o crear el registro en la tabla resultados
            $resultado = Resultado::updateOrCreate(
                [
                    'temporada' => config('tcm.temporada'),
                    'num_carrera' => $numCarrera,
                    'etapa' => $etapa,
                    'cod_ciclista' => $ciclista->cod_ciclista,
                ],
                [
                    'posicion' => $rank,
                    'pts' => $puntos,
                ]
            );

            // Sumar los puntos al valor actual
            $resultado->increment('pts', $puntos);

            $this->info("Actualizados AA puntos para {$name} (Posición: {$rank}, Puntos: {$puntos})");
        }
    }

    private function loadPointConfiguration(string $clasificacion, string $categoria, string $tipo): ?array
    {
        $jsonFile = storage_path('app/config/puntos.json');
        $puntosConfig = json_decode(file_get_contents($jsonFile), true);

        foreach ($puntosConfig as $config) {
            if (
                $config['clasificacion'] === $clasificacion &&
                $config['categoria'] === $categoria &&
                $config['tipo'] === $tipo
            ) {
                return $config;
            }
        }

        return null; // Si no se encuentra configuración
    }

    private function processGeneralResults($spreadsheet, $numCarrera, $etapa)
    {
        $sheet = $spreadsheet->getSheetByName('General results');

        if (!$sheet) {
            $this->warn("No se encontró la pestaña 'General results'.");
            return;
        }

        foreach ($sheet->getRowIterator(2) as $row) {
            $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();

            if (!$rank || !$name) {
                continue; // Salta filas incompletas.
            }

            $ciclista = Ciclista::where('nom_ape', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            Resultado::where([
                'temporada' => config('tcm.temporada'),
                'num_carrera' => $numCarrera,
                'etapa' => $etapa,
                'cod_ciclista' => $ciclista->cod_ciclista,
            ])->update(['pos_gral' => $rank]);
        }
    }

    private function processPointsResults($spreadsheet, $numCarrera, $etapa)
    {
        $sheet = $spreadsheet->getSheetByName('Points');

        if (!$sheet) {
            $this->warn("No se encontró la pestaña 'General results'.");
            return;
        }

        foreach ($sheet->getRowIterator(2) as $row) {
            $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();

            if (!$rank || !$name) {
                continue; // Salta filas incompletas.
            }

            $ciclista = Ciclista::where('nom_ape', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            Resultado::where([
                'temporada' => config('tcm.temporada'),
                'num_carrera' => $numCarrera,
                'etapa' => $etapa,
                'cod_ciclista' => $ciclista->cod_ciclista,
            ])->update(['gral_reg' => $rank]);
        }
    }

    private function processMountainResults($spreadsheet, $numCarrera, $etapa)
    {
        $sheet = $spreadsheet->getSheetByName('Mountain');

        if (!$sheet) {
            $this->warn("No se encontró la pestaña 'General results'.");
            return;
        }

        foreach ($sheet->getRowIterator(2) as $row) {
            $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();

            if (!$rank || !$name) {
                continue; // Salta filas incompletas.
            }

            $ciclista = Ciclista::where('nom_ape', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            Resultado::where([
                'temporada' => config('tcm.temporada'),
                'num_carrera' => $numCarrera,
                'etapa' => $etapa,
                'cod_ciclista' => $ciclista->cod_ciclista,
            ])->update(['gral_mon' => $rank]);
        }
    }

    private function processYoungResults($spreadsheet, $numCarrera, $etapa)
    {
        $sheet = $spreadsheet->getSheetByName('Young results');

        if (!$sheet) {
            $this->warn("No se encontró la pestaña 'Young results'.");
            return;
        }

        foreach ($sheet->getRowIterator(2) as $row) {
            $rank = null; // Inicializar la variable para evitar errores
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();
            $posRealRaw = $sheet->getCell("E{$row->getRowIndex()}")->getValue();

            if (!$name || !$posRealRaw) {
                continue; // Salta filas incompletas.
            }

            // Extraer el número dentro de paréntesis usando expresión regular
            if (preg_match('/\((\d+)\)/', $posRealRaw, $matches)) {
                $rank = (int)$matches[1]; // Extraer y convertir a entero
            }

            if (!$rank) {
                $this->warn("No se pudo extraer la posición de: $posRealRaw");
                continue; // Salta filas donde no se pudo extraer el número
            }

            $ciclista = Ciclista::where('nom_ape', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            Resultado::where([
                'temporada' => config('tcm.temporada'),
                'num_carrera' => $numCarrera,
                'etapa' => $etapa,
                'cod_ciclista' => $ciclista->cod_ciclista,
            ])->update(['gral_jov' => $rank]);
        }
    }


    // Métodos similares para Points, Mountain, Young, y Team Results...
}
