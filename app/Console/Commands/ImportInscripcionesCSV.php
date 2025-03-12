<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Inscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportInscripcionesCSV extends Command
{
    protected $signature = 'import:inscripciones {temporada} {num_carrera}';
    protected $description = 'Importar inscripciones de corredores desde un archivo CSV en el directorio de imports.';

    public function handle()
    {
        $temporada = $this->argument('temporada');
        $numCarrera = $this->argument('num_carrera'); // NÃºmero de carrera

        // ðŸ“Œ Buscar archivo que comience con "{num_carrera}."
        $importDir = storage_path("app/imports/inscripcionescsv");
        $files = glob("$importDir/{$numCarrera}.*.csv");

        if (empty($files)) {
            $this->error("No se encontrÃ³ un archivo CSV que empiece con: {$numCarrera}. en $importDir");
            return;
        }

        if (count($files) > 1) {
            $this->error("Se encontraron mÃºltiples archivos para num_carrera: {$numCarrera}. Especifique el correcto manualmente.");
            return;
        }

        $rutaArchivo = $files[0]; // Tomamos el Ãºnico archivo encontrado

        $this->info("Procesando inscripciones desde: " . basename($rutaArchivo));

        DB::beginTransaction();

        try {
            $file = fopen($rutaArchivo, 'r');

            while (($row = fgetcsv($file)) !== false) {
                foreach ($row as $nombre) {
                    $nombre = trim($nombre);

                    // Ignorar valores vacÃ­os o "#N/A"
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

                    // ðŸ”¹ Insertar inscripciÃ³n (solo 1 por ciclista y carrera)
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

                    $this->info("InscripciÃ³n registrada para: $nombre en num_carrera: $numCarrera");
                }
            }

            fclose($file);
            DB::commit();
            $this->info("âœ… Todas las inscripciones se han importado correctamente.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("âŒ Error al importar inscripciones: " . $e->getMessage());
        }
    }
}
