<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ciclista;
use App\Models\Inscripcion;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProcessFormaResults extends Command
{
    protected $signature = 'process:forma-results {folder}';
    protected $description = 'Procesa un archivo de forma de múltiples semanas y actualiza la BD.';

    public function handle()
    {
        $folder = $this->argument('folder');
        $importDir = storage_path("app/imports/resultados/semana-$folder");
        $exportDir = storage_path('app/exports/formas');

        $inputFile = "$importDir/import Forma Semana $folder.xlsx";
        $outputFile = "$exportDir/Forma Semana $folder.xlsx";

        if (!file_exists($inputFile)) {
            $this->error("El archivo $inputFile no existe.");
            return Command::FAILURE;
        }

        try {
            $spreadsheet = IOFactory::load($inputFile);
        } catch (\Exception $e) {
            $this->error("Error al abrir el archivo: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info("Procesando archivo: $inputFile");

        $newSpreadsheet = new Spreadsheet();
        $sheetCount = $spreadsheet->getSheetCount();

        if ($sheetCount % 2 !== 0) {
            $this->error("El archivo tiene un número impar de pestañas, debe ser par.");
            return Command::FAILURE;
        }

        $temporada = config('tcm.temporada'); // Obtenemos la temporada actual
        $actualizaciones = []; // Para almacenar formas antes de actualizar la BD

        for ($i = 0; $i < $sheetCount; $i += 2) {
            $firstSheet = $spreadsheet->getSheet($i);
            $secondSheet = $spreadsheet->getSheet($i + 1);
            $sheetName = $firstSheet->getTitle();
            $numCarrera = $this->extractNumCarrera($sheetName); // Extraer número de carrera del nombre de la pestaña

            if (!$numCarrera) {
                $this->warn("No se pudo determinar el num_carrera de la pestaña: $sheetName. Se omite.");
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

            $ciclistasData = Ciclista::whereIn('cod_ciclista', array_keys($ciclistasBuscados))
                ->with('equipo')
                ->get()
                ->keyBy('cod_ciclista');

            $newSheet = $newSpreadsheet->createSheet();
            $newSheet->setTitle($sheetName);

            $newSheet->setCellValue("A1", "cod_ciclista");
            $newSheet->setCellValue("B1", "nom_abrev");
            $newSheet->setCellValue("C1", "equipo");
            $newSheet->setCellValue("D1", "rol");
            $newSheet->setCellValue("E1", "forma");

            $rowNum = 2;
            foreach ($ciclistasBuscados as $codCiclista => $data) {
                $ciclista = $ciclistasData[$codCiclista] ?? null;
                if (!$ciclista) continue;

                $newSheet->setCellValue("A$rowNum", $codCiclista);
                $newSheet->setCellValue("B$rowNum", $ciclista->nom_abrev ?? 'N/A');
                $newSheet->setCellValue("C$rowNum", $ciclista->equipo->nombre_equipo ?? 'N/A');
                $newSheet->setCellValue("D$rowNum", $this->translateRole($data['rol']));
                $newSheet->setCellValue("E$rowNum", $data['forma'] ?? 'N/A');

                $rowNum++;
            }
        }

        if (!file_exists($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        // Eliminar la primera hoja vacía que se crea por defecto
        if ($newSpreadsheet->getSheetCount() > 1) {
            $newSpreadsheet->removeSheetByIndex(0);
        }

        $writer = new Xlsx($newSpreadsheet);
        $writer->save($outputFile);

        $this->info("Archivo generado: $outputFile");

        // **Actualizar la BD con los valores de forma**
        $this->actualizarFormas($actualizaciones, $temporada);

        return Command::SUCCESS;
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

    private function translateRole($role)
    {
        return match ((int) $role) {
            1 => 'Gregario',
            2 => 'Libre',
            3 => 'Líder',
            4 => 'Sprinter',
            default => 'Desconocido',
        };
    }

    private function extractNumCarrera(string $sheetName): ?int
    {
        // Extraer número de carrera del título de la pestaña
        if (preg_match('/^(\d+)/', $sheetName, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }
}
