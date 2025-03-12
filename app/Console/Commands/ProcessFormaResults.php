<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ciclista;
use App\Models\Inscripcion;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\File;

class ProcessFormaResults extends Command
{
    protected $signature = 'process:forma-results {semana?}';
    protected $description = 'Procesa archivos de forma y actualiza la BD. Si no se especifica semana, procesa todos.';

    public function handle()
    {
        $semana = $this->argument('semana');
        $importDir = storage_path("app/imports/resultados/formas/");
        $exportDir = storage_path('app/exports/formas/');

        // **Buscar archivos según el parámetro**
        if ($semana) {
            $files = [ "{$importDir}import Forma Semana $semana.xlsx" ];
        } else {
            $files = File::glob("{$importDir}import Forma*.xlsx");
        }

        if (empty($files)) {
            $this->error("No se encontraron archivos para procesar.");
            return Command::FAILURE;
        }

        $this->info("Procesando archivos de forma...");
        $temporada = config('tcm.temporada'); 
        $actualizaciones = [];

        foreach ($files as $inputFile) {
            if (!file_exists($inputFile)) {
                $this->warn("Archivo no encontrado: $inputFile. Omitido.");
                continue;
            }

            try {
                $spreadsheet = IOFactory::load($inputFile);
            } catch (\Exception $e) {
                $this->error("Error al abrir el archivo $inputFile: " . $e->getMessage());
                continue;
            }

            $this->procesarArchivo($spreadsheet, $actualizaciones);
            $outputFile = $exportDir . basename($inputFile);

            // Guardar el archivo procesado
            $this->guardarArchivo($spreadsheet, $outputFile);
        }

        // **Actualizar BD con las formas**
        $this->actualizarFormas($actualizaciones, $temporada);
        return Command::SUCCESS;
    }

    private function procesarArchivo($spreadsheet, &$actualizaciones)
    {
        $sheetCount = $spreadsheet->getSheetCount();
        if ($sheetCount % 2 !== 0) {
            $this->warn("El archivo tiene un número impar de pestañas, debe ser par.");
            return;
        }

        for ($i = 0; $i < $sheetCount; $i += 2) {
            $firstSheet = $spreadsheet->getSheet($i);
            $secondSheet = $spreadsheet->getSheet($i + 1);
            $sheetName = $firstSheet->getTitle();
            $numCarrera = $this->extractNumCarrera($sheetName);

            if (!$numCarrera) {
                $this->warn("No se pudo determinar el num_carrera de la pestaña: $sheetName. Omitida.");
                continue;
            }

            $ciclistasBuscados = [];
            $lastRow = $secondSheet->getHighestRow();

            for ($row = 2; $row <= $lastRow; $row++) {
                $codCiclista = $secondSheet->getCell("C$row")->getValue();
                $rol = $secondSheet->getCell("E$row")->getValue();
                $ciclistasBuscados[$codCiclista] = [
                    'rol' => $rol,
                    'num_carrera' => $numCarrera
                ];
            }

            $lastRow = $firstSheet->getHighestRow();
            for ($row = 2; $row <= $lastRow; $row++) {
                $codCiclista = $firstSheet->getCell("A$row")->getValue();
                if (isset($ciclistasBuscados[$codCiclista])) {
                    $forma = $firstSheet->getCell("L$row")->getValue();
                    $ciclistasBuscados[$codCiclista]['forma'] = $forma;

                    if (!empty($forma)) {
                        $actualizaciones[] = [
                            'cod_ciclista' => $codCiclista,
                            'num_carrera' => $numCarrera,
                            'forma' => $forma,
                            'rol' => $ciclistasBuscados[$codCiclista]['rol'] ?? null
                        ];
                    }
                }
            }
        }
    }

    private function guardarArchivo($spreadsheet, $outputFile)
    {
        $writer = new Xlsx($spreadsheet);
        if (!file_exists(dirname($outputFile))) {
            mkdir(dirname($outputFile), 0777, true);
        }
        $writer->save($outputFile);
        $this->info("Archivo generado: $outputFile");
    }

    private function actualizarFormas(array $actualizaciones, int $temporada)
    {
        if (empty($actualizaciones)) {
            $this->info("No hay formas para actualizar en la BD.");
            return;
        }

        $this->info("Actualizando formas en la base de datos...");

        foreach ($actualizaciones as $data) {
            Inscripcion::where('cod_ciclista', $data['cod_ciclista'])
                ->where('num_carrera', $data['num_carrera'])
                ->where('temporada', $temporada)
                ->update([
                    'rol' => $data['rol'],
                    'forma' => $data['forma'],
                ]);
        }

        $this->info("Actualización de formas completada.");
    }

    private function extractNumCarrera(string $sheetName): ?int
    {
        if (preg_match('/^(\d+)/', $sheetName, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }
}
