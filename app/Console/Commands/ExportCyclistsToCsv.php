<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use Illuminate\Console\Command;

class ExportCyclistsToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:cyclists-to-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporta los datos de la tabla Ciclistas a un archivo CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/exports/ciclistas.csv');

        // Crear el directorio si no existe
        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $file = fopen($filePath, 'w');

        // Escribir encabezados
        $headers = [
            'id', 'temporada', 'clave_id', 'nombre', 'apellido', 'nom_ape', 'nom_abrev', 
            'pais', 'especialidad', 'edad', 'lla', 'mon', 'col', 'cri', 'pro', 'pav',
            'spr', 'acc', 'des', 'com', 'ene', 'res', 'rec', 'media', 'u24', 'conti',
            'equipo_id'
        ];
        fputcsv($file, $headers);

        // Escribir los datos de la tabla
        Ciclista::all()->each(function ($ciclista) use ($file, $headers) {
            // Filtrar solo los campos necesarios
            $filteredData = collect($ciclista->toArray())->only($headers)->toArray();
            fputcsv($file, $filteredData);
        });

        fclose($file);

        $this->info("Datos exportados correctamente a: $filePath");
        return Command::SUCCESS;
    }
}
