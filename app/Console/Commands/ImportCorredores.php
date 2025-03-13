<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCorredores extends Command
{
    protected $signature = 'import:corredores {num_temporada}';
    protected $description = 'Importa corredores desde un archivo CSV para la temporada especificada.';

    public function handle()
    {
        // Obtener el número de temporada desde el argumento
        $temporada = $this->argument('num_temporada');
        $filePath = storage_path("app/imports/corredores/{$temporada}/corredores.csv");

        if (!file_exists($filePath)) {
            $this->error("El archivo CSV no se encontró en la ruta: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer encabezados

        DB::beginTransaction();

        $addedCount = 0;
        $failedCount = 0;
        $failedRecords = [];

        try {
            // Cargar todos los equipos de la temporada especificada
            $equipos = Equipo::where('temporada', $temporada)
                ->pluck('cod_equipo', 'nombre_en_bd')
                ->toArray();
            // $equipos = Equipo::where('temporada', $temporada)
            //     ->get()
            //     ->keyBy(fn($e) => $e->nombre_equipo . '-' . $e->temporada) // Clave única por temporada
            //     ->toArray();
// dd($equipos);
            while ($row = fgetcsv($file)) {
                $data = array_combine($header, $row);
                $codEquipo = $equipos[$data['Equipo']] ?? null;
                // Buscar equipo con clave `nombre_equipo-temporada`
                // $codEquipo = $equipos[$data['Equipo'] . '-' . $temporada]['cod_equipo'] ?? null;                

                try {
                    // Insertar o actualizar ciclista
                 
                    Ciclista::updateOrCreate(
                        [
                            'cod_ciclista' => $data['ID'],
                            'temporada' => $temporada
                        ],
                        [
                            'nombre' => $data['Nombre'],
                            'apellido' => $data['Nombre'],
                            'nom_ape' => $data['Nombre'],
                            'nom_abrev' => $data['Nombre'],
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
                            'es_u24' => ($data['Edad'] <= 24 && (float) str_replace(',', '.', $data['Media']) < 75),
                            'es_conti' => collect([
                                $data['LLA'], $data['MON'], $data['COL'], $data['CRI'], $data['PRO'], $data['PAV'], 
                                $data['SPR'], $data['ACC'], $data['DES'], $data['COM'], $data['ENE'], $data['RES'], 
                                $data['REC']
                            ])->every(fn($value) => (float) str_replace(',', '.', $value) < 78),
                            'es_pro' => collect([
                                $data['LLA'], $data['MON'], $data['COL'], $data['CRI'], $data['PRO'], $data['PAV'], 
                                $data['SPR'], $data['ACC'], $data['DES'], $data['COM'], $data['ENE'], $data['RES'], 
                                $data['REC']
                            ])->every(fn($value) => (float) str_replace(',', '.', $value) < 80),
                            'cod_equipo' => $codEquipo,
                        ]
                    );

                    $addedCount++;
                } catch (\Exception $e) {
                    // $this->error("Error al actualizar los datos: " . $e->getMessage());
                    $failedCount++;
                    $failedRecords[] = $data['ID'] ?? 'Desconocido';
                }
            }

            DB::commit();

            $this->info("Los datos se han importado correctamente para la temporada $temporada.");
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
