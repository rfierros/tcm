<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ciclista;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProcessFormaResults extends Command
{
    protected $signature = 'process:forma-results {folder}';
    protected $description = 'Procesa el archivo de forma de una semana y genera el archivo de salida.';

    public function handle()
    {
        // 🗂️ Definir rutas de entrada y salida
        $folder = $this->argument('folder');
        $importDir = storage_path("app/imports/resultados/semana-$folder");
        $exportDir = storage_path('app/exports/formas');

        // 📂 Definir archivos
        $inputFile = "$importDir/import Forma Semana $folder.xlsx";
        $outputFile = "$exportDir/Forma Semana $folder.xlsx";

        // 🛑 Verificar que el archivo de entrada existe
        if (!file_exists($inputFile)) {
            $this->error("El archivo $inputFile no existe.");
            return Command::FAILURE;
        }

        // 📖 Cargar el archivo Excel
        try {
            $spreadsheet = IOFactory::load($inputFile);
        } catch (\Exception $e) {
            $this->error("Error al abrir el archivo: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info("Procesando archivo: $inputFile");

        // 📝 Leer la segunda pestaña (obtenemos los ciclistas que nos interesan)
        $secondSheet = $spreadsheet->getSheet(1);
        $lastRow = $secondSheet->getHighestRow();

        $ciclistasBuscados = [];
        for ($row = 2; $row <= $lastRow; $row++) { // Saltamos la cabecera
            $codCiclista = $secondSheet->getCell("C$row")->getValue();
            $rol = $secondSheet->getCell("E$row")->getValue();
            $ciclistasBuscados[$codCiclista] = ['rol' => $rol];
        }

        $this->info("Se han encontrado " . count($ciclistasBuscados) . " ciclistas en la segunda pestaña.");

        // 🔍 Buscar las formas en la primera pestaña
        $firstSheet = $spreadsheet->getSheet(0);
        $lastRow = $firstSheet->getHighestRow();

        for ($row = 2; $row <= $lastRow; $row++) {
            $codCiclista = $firstSheet->getCell("A$row")->getValue();
            if (isset($ciclistasBuscados[$codCiclista])) {
                $forma = $firstSheet->getCell("L$row")->getValue();
                $ciclistasBuscados[$codCiclista]['forma'] = $forma;
            }
        }

        $this->info("Se han encontrado formas para los ciclistas seleccionados.");

        // 🔄 Consultar la BD para obtener nombres y equipos
        $ciclistasData = Ciclista::whereIn('cod_ciclista', array_keys($ciclistasBuscados))
            ->with('equipo') // Suponiendo que Ciclista tiene relación con Equipos
            ->get()
            ->keyBy('cod_ciclista');

        // 📤 Generar archivo de salida
        $newSpreadsheet = new Spreadsheet();
        $sheet = $newSpreadsheet->getActiveSheet();
        $sheet->setTitle("Forma Semana $folder");

        // 📑 Encabezados
        $sheet->setCellValue("A1", "cod_ciclista");
        $sheet->setCellValue("B1", "nom_abrev");
        $sheet->setCellValue("C1", "equipo");
        $sheet->setCellValue("D1", "rol");
        $sheet->setCellValue("E1", "forma");

        // ✏️ Insertar datos
        $rowNum = 2;
        foreach ($ciclistasBuscados as $codCiclista => $data) {
            $ciclista = $ciclistasData[$codCiclista] ?? null;
            if (!$ciclista) continue;

            $sheet->setCellValue("A$rowNum", $codCiclista);
            $sheet->setCellValue("B$rowNum", $ciclista->nom_abrev ?? 'N/A');
            $sheet->setCellValue("C$rowNum", $ciclista->equipo->nombre_equipo ?? 'N/A');
            $sheet->setCellValue("D$rowNum", $this->translateRole($data['rol']));
            $sheet->setCellValue("E$rowNum", $data['forma'] ?? 'N/A');

            $rowNum++;
        }

        // 💾 Guardar archivo
        if (!file_exists($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        $writer = new Xlsx($newSpreadsheet);
        $writer->save($outputFile);

        $this->info("Archivo generado: $outputFile");
        return Command::SUCCESS;
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

}
