<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCyclistsFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cyclists-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa los datos del archivo ciclistas.csv en la tabla Ciclistas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/exports/ciclistas.csv');

        if (!file_exists($filePath)) {
            $this->error("El archivo CSV no se encontró en la ruta: $filePath");
            return Command::FAILURE;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer los encabezados del CSV

        if (!$header) {
            $this->error("El archivo CSV está vacío o no tiene encabezados válidos.");
            fclose($file);
            return Command::FAILURE;
        }

        $importedCount = 0; // Contador de registros procesados

        while (($row = fgetcsv($file)) !== false) {
            // Limitar columnas a las del encabezado
            $row = array_slice($row, 0, count($header));

            // Validar que la fila tiene el mismo número de columnas que los encabezados
            if (count($header) !== count($row)) {
                $this->warn("Fila inválida: " . implode(', ', $row));
                continue; // Saltar filas con errores
            }

            // Crear un array asociativo con los encabezados como claves
            $data = array_combine($header, $row);

            // Manejar valores vacíos en cod_equipo
            $data['cod_equipo'] = $data['cod_equipo'] === '' ? null : $data['cod_equipo'];

            try {
                // Procesar registro
                Ciclista::updateOrCreate(
                    ['cod_ciclista' => $data['cod_ciclista']], // Condición para identificar el registro
                    [
                        'temporada' => $data['temporada'],
                        'nombre' => $data['nombre'],
                        'apellido' => $data['apellido'],
                        'nom_ape' => $data['nom_ape'],
                        'nom_abrev' => $data['nom_abrev'],
                        'pais' => $data['pais'],
                        'especialidad' => $data['especialidad'],
                        'edad' => $data['edad'],
                        'lla' => $data['lla'],
                        'mon' => $data['mon'],
                        'col' => $data['col'],
                        'cri' => $data['cri'],
                        'pro' => $data['pro'],
                        'pav' => $data['pav'],
                        'spr' => $data['spr'],
                        'acc' => $data['acc'],
                        'des' => $data['des'],
                        'com' => $data['com'],
                        'ene' => $data['ene'],
                        'res' => $data['res'],
                        'rec' => $data['rec'],
                        'media' => $data['media'],
                        'u24' => $data['u24'],
                        'conti' => $data['conti'],
                        'cod_equipo' => $data['cod_equipo'], // Dejar null si está vacío
                    ]
                );

                $importedCount++; // Incrementar contador
            } catch (\Exception $e) {
                $this->warn("Error al procesar ciclista con cod_ciclista {$data['cod_ciclista']}: " . $e->getMessage());
                continue; // Continuar con el siguiente registro
            }
        }

        fclose($file); // Cerrar el archivo al final

        $this->info("Proceso completado. Total de registros importados o actualizados: $importedCount.");
        return Command::SUCCESS;
    }
}
