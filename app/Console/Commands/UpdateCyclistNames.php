<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use Illuminate\Console\Command;

class UpdateCyclistNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:cyclist-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los nombres y apellidos de los ciclistas según el archivo nombres_apellidos.csv';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/imports/corredores/nombres_apellidos.csv');

        if (!file_exists($filePath)) {
            $this->error("El archivo CSV no se encontró en la ruta: $filePath");
            return Command::FAILURE;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer los encabezados

        $updatedCount = 0;

        try {
            while ($row = fgetcsv($file)) {
                $data = array_combine($header, $row);

                // Buscar el ciclista por clave_id
                $ciclista = Ciclista::where('clave_id', $data['id'])->first();

                if ($ciclista) {
                    // Actualizar los datos del ciclista
                    $ciclista->update([
                        'nombre' => $data['nombre'],
                        'apellido' => $data['apellido'],
                        'nom_ape' => $data['nombre'] . ' ' . $data['apellido'],
                    ]);

                    $updatedCount++;
                } else {
                    $this->warn("No se encontró un ciclista con clave_id: {$data['id']}");
                }
            }

            $this->info("Proceso completado. Total de registros actualizados: $updatedCount.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error al actualizar los datos: " . $e->getMessage());
            return Command::FAILURE;
        } finally {
            fclose($file);
        }
    }
}
