<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCorredoresU24 extends Command
{
    protected $signature = 'import:corredoresu24';
    protected $description = 'Importa corredores para el Draft U24 desde un archivo CSV.';

    public function handle()
    {
        $filePath = storage_path('app/imports/corredores/draft-u24-t5.csv');
        $temporada = 5;

        if (!file_exists($filePath)) {
            $this->error("El archivo CSV no se encontró en la ruta: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer los encabezados

        DB::beginTransaction();

        $addedCount = 0; // Contador de registros añadidos
        $failedCount = 0; // Contador de registros fallidos
        $failedRecords = []; // Lista para almacenar los registros fallidos

        try {
            // Cargar todos los equipos de la temporada 4 en un array con el nombre como clave
            $equipos = Equipo::where('temporada', $temporada)
                ->pluck('cod_equipo', 'nombre_equipo')
                ->toArray();

            while ($row = fgetcsv($file)) {
                $data = array_combine($header, $row);

                $codEquipo = $equipos[$data['Equipo']] ?? null;
                $draft = 'u24';

                try {
                    // Inserta en la base de datos
                    Ciclista::create([
                        'cod_ciclista' => $data['ID'],
                        'temporada' => $temporada,
                        'nombre' => $data['Nombre'],
                        'apellido' => $data['Nombre'],
                        'nom_ape' => $data['Nombre'], // nombre + apellido
                        'nom_abrev' => $data['Nombre'], // iniciales + apellido
                        'pais' => $data['Pais'],
                        'especialidad' => strtolower($data['Especialidad']),
                        'edad' => $data['Edad'],
                        'lla' => (float) str_replace(',', '.', $data['LLA']),
                        'mon' => (float) str_replace(',', '.', $data['MON']),
                        'col' => (float) str_replace(',', '.', $data['COL']),
                        'cri' => (float) str_replace(',', '.', $data['CRI']),
                        'pro' => (float) str_replace(',', '.', $data['PRO']),
                        'pav' => (float) str_replace(',', '.', $data['PAV']),
                        'spr' => (float) str_replace(',', '.', $data['SPR']),
                        'acc' => (float) str_replace(',', '.', $data['ACC']),
                        'des' => (float) str_replace(',', '.', $data['DES']),
                        'com' => (float) str_replace(',', '.', $data['COM']),
                        'ene' => (float) str_replace(',', '.', $data['ENE']),
                        'res' => (float) str_replace(',', '.', $data['RES']),
                        'rec' => (float) str_replace(',', '.', $data['REC']),
                        'media' => (float) str_replace(',', '.', $data['Media']),
                        'u24' => ($data['Edad'] <= 24 && (float) str_replace(',', '.', $data['Media']) < 75),
                        'conti' => collect([
                            $data['LLA'], $data['MON'], $data['COL'], $data['CRI'], $data['PRO'], $data['PAV'], 
                            $data['SPR'], $data['ACC'], $data['DES'], $data['COM'], $data['ENE'], $data['RES'], 
                            $data['REC']
                        ])->every(fn($value) => (float) str_replace(',', '.', $value) < 78),
                        'draft' => $draft, // seleccionable draft de u24
                        'pos_draft' => null, // null es available para elegir en el draft de u24
                        'cod_equipo' => null,
                    ]);

                    $addedCount++;
                } catch (\Exception $e) {
                    $this->info("Error: $e");
                    $failedCount++;
                    $failedRecords[] = $data['ID'] ?? 'Desconocido';
                }
            }

            DB::commit();

            $this->info("Los datos u24 se han importado correctamente.");
            $this->info("Registros añadidos: $addedCount");
            if ($failedCount > 0) {
                $this->warn("Registros fallidos: $failedCount");
                $this->warn("IDs fallidos: " . implode(', ', $failedRecords));
            }
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error al importar datos: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }
}
