<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Inscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportInscripcionesCSV extends Command
{
    protected $signature = 'import:inscripciones {temporada} {num_carrera?}';
    protected $description = 'Importar inscripciones de corredores desde un archivo CSV en el directorio de imports.';
// php artisan import:inscripciones 5 13  # Procesa el archivo "app/imports/inscripcionescsv/5/13.*.csv"
// php artisan import:inscripciones 4     # Procesa TODOS los archivos CSV dentro de "app/imports/inscripcionescsv/4"    

    public function handle()
    {
        $temporada = $this->argument('temporada');
        $numCarrera = $this->argument('num_carrera');

        // Definir el directorio según la temporada
        $importDir = storage_path("app/imports/inscripcionescsv/{$temporada}");

        if (!File::exists($importDir)) {
            $this->error("El directorio $importDir no existe.");
            return;
        }

        // Buscar archivos
        if ($numCarrera) {
            $files = glob("{$importDir}/{$numCarrera}.*.csv");
        } else {
            $files = glob("{$importDir}/*.csv"); // Si no hay num_carrera, tomar todos los archivos
        }

        if (empty($files)) {
            $this->error("No se encontraron archivos CSV en $importDir.");
            return;
        }

        foreach ($files as $rutaArchivo) {
            $this->procesarArchivo($rutaArchivo, $temporada);
        }

        $this->info("Todos los archivos han sido procesados correctamente.");
    }

    private function procesarArchivo($rutaArchivo, $temporada)
    {
        $numCarrera = $this->extraerNumCarrera($rutaArchivo);

        if (!$numCarrera) {
            $this->warn("No se pudo determinar el num_carrera de " . basename($rutaArchivo) . ". Omitido.");
            return;
        }

        $this->info("Procesando inscripciones desde: " . basename($rutaArchivo));

        DB::beginTransaction();

        try {
            $file = fopen($rutaArchivo, 'r');

            while (($row = fgetcsv($file)) !== false) {
                foreach ($row as $nombre) {
                    $nombre = trim($nombre);

                    // Ignorar valores vacíos o "#N/A"
                    if (empty($nombre) || $nombre === '#N/A') {
                        continue;
                    }

                    // Buscar el ciclista en la base de datos
                    $ciclista = Ciclista::where('nom_abrev', $nombre)
                        ->where('temporada', $temporada)
                        ->first();

                    if (!$ciclista) {
                        $this->warn("Ciclista no encontrado: $nombre");
                        continue;
                    }

                    $codCiclista = $ciclista->cod_ciclista;
                    $codEquipo = $ciclista->cod_equipo;

                    // Insertar inscripciones asegurando que no se dupliquen
                    Inscripcion::updateOrCreate(
                        [
                            'temporada' => $temporada,
                            'num_carrera' => $numCarrera,
                            'cod_ciclista' => $codCiclista,
                        ],
                        [
                            'cod_equipo' => $codEquipo,
                        ]
                    );

                    $this->info("Inscripción csv para: $nombre en num_carrera: $numCarrera");
                }
            }

            fclose($file);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error al importar inscripciones: " . $e->getMessage());
        }
    }

    private function extraerNumCarrera($filePath)
    {
        // Extrae el número de carrera del nombre del archivo (ej: "66.nombre.csv" → 66)
        if (preg_match('/(\d+)\./', basename($filePath), $matches)) {
            return (int) $matches[1];
        }

        return null;
    }
}
