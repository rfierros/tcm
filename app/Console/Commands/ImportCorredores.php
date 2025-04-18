<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCorredores extends Command
{
    protected $signature = 'import:corredores {num_temporada} {archivo}';
    protected $description = 'Importa corredores desde un archivo CSV para la temporada especificada.';

    public function handle()
    {
        $temporada = $this->argument('num_temporada');
        $archivo = $this->argument('archivo');
        $filePath = storage_path("app/imports/corredores/{$temporada}/{$archivo}.csv");

        if (!file_exists($filePath)) {
            $this->error("El archivo CSV no se encontró en la ruta: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer encabezados

        DB::beginTransaction();

        $addedCount = 0;
        $skippedCount = 0;
        $skippedRecords = [];

        try {
            // Cargar equipos de la temporada
            $equipos = Equipo::where('temporada', $temporada)
                ->pluck('cod_equipo', 'nombre_equipo')
                ->toArray();

            while ($row = fgetcsv($file)) {
                $data = array_combine($header, $row);
                $codEquipo = $equipos[$data['Equipo']] ?? null;

                // Comprobar si el ciclista ya existe
                $existe = Ciclista::where('cod_ciclista', $data['ID'])
                    ->where('temporada', $temporada)
                    ->exists();

                if ($existe) {
                    $skippedCount++;
                    $skippedRecords[] = $data['ID'];
                    continue;
                }

                // Convertimos Edad y Media
                $edad = (int) $data['Edad'];
                $media = (float) str_replace(',', '.', $data['Media']);

                // Valoramos si es U24
                $esU24 = $edad <= 24 && $media < 75;

                // Valoramos si es .1 (Conti)
                $valoresConti = collect([
                    $data['LLA'], $data['MON'], $data['COL'], $data['CRI'], $data['PRO'], $data['PAV'], 
                    $data['SPR'], $data['ACC'], $data['DES'], $data['COM'], $data['ENE'], $data['RES'], 
                    $data['REC']
                ]);
                $esConti = $valoresConti->every(fn($value) => (float) str_replace(',', '.', $value) < 78);

                // Valoramos si es .Pro
                $valoresPro = collect([
                    $data['MON'], $data['COL'], $data['CRI'], $data['PAV'], $data['SPR']
                ]);
                $esPro = $valoresPro->every(fn($value) => (float) str_replace(',', '.', $value) < 80);

                // Insertar nuevo ciclista
                Ciclista::create([
                    'cod_ciclista' => $data['ID'],
                    'temporada' => $temporada,
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
                    'es_u24' => $esU24,
                    'es_conti' => $esConti,
                    'es_pro' => $esPro,
                    'max_dias' => $esConti ? 55 : 50, // 55 dias o 50.
                    'cod_equipo' => $codEquipo,
                ]);

                $addedCount++;
            }

            DB::commit();

            $this->info("Los datos se han importado correctamente para la temporada $temporada.");
            $this->info("Registros añadidos: $addedCount");
            if ($skippedCount > 0) {
                $this->warn("Registros omitidos porque ya existían: $skippedCount");
                $this->warn("IDs omitidos: " . implode(', ', $skippedRecords));
            }
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error al importar datos: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }
}
