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
            [$carreraId, $etapa] = $this->extractRaceAndStage($fileNameWithoutExt);

            if (!$carreraId || !$etapa) {
                $this->error("No se pudo determinar carrera_id y etapa del archivo: $fileName");
                return Command::FAILURE;
            }

            $this->info("Carrera ID: $carreraId, Etapa: $etapa");

            // Procesar las pestañas del archivo
            $this->processStageResults($spreadsheet, $carreraId, $etapa);
            $this->processGeneralResults($spreadsheet, $carreraId, $etapa);
            $this->processPointsResults($spreadsheet, $carreraId, $etapa);
            $this->processMountainResults($spreadsheet, $carreraId, $etapa);
            $this->processYoungResults($spreadsheet, $carreraId, $etapa);
            $this->processTeamResults($spreadsheet, $carreraId, $etapa);

            $this->info("Archivo procesado exitosamente.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error al procesar el archivo: " . $e->getMessage());
            return Command::FAILURE;
        }
    }


    private function extractRaceAndStage(string $fileName): array
    {
        preg_match('/^(\d+).*(Etapa (\d+))?$/', $fileName, $matches);
        $carreraId = $matches[1] ?? null;
        $etapa = $matches[3] ?? 1; // Asume etapa 1 si no está especificada.
        return [(int)$carreraId, (int)$etapa];
    }

    private function processStageResults($spreadsheet, $carreraId, $etapa)
    {
        $sheet = $spreadsheet->getSheetByName('Stage results');

        if (!$sheet) {
            $this->warn("No se encontró la pestaña 'Stage results'.");
            return;
        }

        foreach ($sheet->getRowIterator(2) as $row) { // Asume encabezados en la fila 1.
            $rank = $sheet->getCell("A{$row->getRowIndex()}")->getValue();
            $name = $sheet->getCell("B{$row->getRowIndex()}")->getValue();
            $time = $sheet->getCell("C{$row->getRowIndex()}")->getValue();

            if (!$rank || !$name) {
                continue; // Salta filas incompletas.
            }

            $ciclista = Ciclista::where('nombre', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            Resultado::updateOrCreate(
                [
                    'temporada' => config('tcm.temporada'),
                    'carrera_id' => $carreraId,
                    'etapa' => $etapa,
                    'ciclista_id' => $ciclista->id,
                ],
                [
                    'posicion' => $rank,
                    'tiempo' => $time,
                ]
            );
        }
    }

    private function processGeneralResults($spreadsheet, $carreraId, $etapa)
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

            $ciclista = Ciclista::where('nombre', $name)->first();

            if (!$ciclista) {
                $this->warn("Ciclista no encontrado: $name");
                continue;
            }

            Resultado::where([
                'temporada' => config('tcm.temporada'),
                'carrera_id' => $carreraId,
                'etapa' => $etapa,
                'ciclista_id' => $ciclista->id,
            ])->update(['pos_gral' => $rank]);
        }
    }

    // Métodos similares para Points, Mountain, Young, y Team Results...
}
