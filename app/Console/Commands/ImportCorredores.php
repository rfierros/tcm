<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCorredores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:corredores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/imports/corredores.csv');
        $temporada = 4;

        if (!file_exists($filePath)) {
            $this->error("El archivo CSV no se encontró en la ruta: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer los encabezados

        DB::beginTransaction();

        try {
        // Cargar todos los equipos de la temporada 4 en un array con el nombre como clave
            $equipos = Equipo::where('temporada', $temporada)->pluck('id', 'nombre_equipo')->toArray();

            while ($row = fgetcsv($file)) {
                $data = array_combine($header, $row);

                $equipoId = $equipos[$data['Equipo']] ?? null;

                // Inserta en la base de datos
            Ciclista::create([
                'clave_id' => $data['ID'],
                'temporada' => $temporada,
                'nombre' => $data['Nombre'],
                'apellido' => $data['Nombre'],
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
                'conti' => collect([$data['LLA'], $data['MON'], $data['COL'], $data['CRI'], $data['PRO'], $data['PAV'], $data['SPR'], $data['ACC'], $data['DES'], $data['COM'], $data['ENE'], $data['RES'], $data['REC']])
                                ->every(fn($value) => (float) str_replace(',', '.', $value) < 78),
                'equipo_id' => $equipoId,
            ]);
            }

            DB::commit();
            $this->info("Los datos se han importado correctamente.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error al importar datos: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }
}