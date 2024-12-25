<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Resultado;
use App\Models\Ciclista;
use App\Models\Equipo;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessRaceResults extends Command
{
    protected $signature = 'process:race-results {file}';
    protected $description = 'Procesa un archivo .xlsx de resultados y actualiza la tabla resultados.';

    public function handle()
    {
        // Directorio donde se almacenan los archivos
        $importDir = storage_path('app/imports');

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
                $this->error("No se pudo determinar carrera_id y etapa del archivo: $fileName");
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
    // Mejor expresión regular para extraer carrera_id y etapa
    //preg_match('/^(\d+).*(?:Etapa\s(\d+))?/i', $fileName, $matches);
    preg_match('/^(\d+).*Etapa\s(\d+)/i', $fileName, $matches);

    // Debugging opcional para verificar los valores capturados
    $this->warn("Var valor 0: " . ($matches[0] ?? 'No encontrado'));
    $this->warn("Var valor 1: " . ($matches[1] ?? 'No encontrado'));
    $this->warn("Var valor 2: " . ($matches[2] ?? 'No encontrado'));

    // Capturar carrera_id y etapa
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

            Resultado::updateOrCreate(
                [
                    'temporada' => config('tcm.temporada'),
                    'num_carrera' => $numCarrera,
                    'etapa' => $etapa,
                    'ciclista_id' => $ciclista->id,
                ],
                [
                    'posicion' => $rank
                ]
            );
        }
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
                'ciclista_id' => $ciclista->id,
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
                'ciclista_id' => $ciclista->id,
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
                'ciclista_id' => $ciclista->id,
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
                'ciclista_id' => $ciclista->id,
            ])->update(['gral_jov' => $rank]);
        }
    }


    // Métodos similares para Points, Mountain, Young, y Team Results...
}
