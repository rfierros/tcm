<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Resultado;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportInscripcionesCSV extends Command
{
    protected $signature = 'import:inscripciones {temporada} {archivo}';
    protected $description = 'Importar inscripciones de corredores desde un archivo CSV';

    public function handle()
    {
        $temporada = $this->argument('temporada');
        $archivo = $this->argument('archivo'); // Nombre del archivo CSV
        $rutaArchivo = storage_path("app/imports/inscripciones/$archivo");

        if (!file_exists($rutaArchivo)) {
            $this->error("El archivo no existe: $rutaArchivo");
            return;
        }

        // Extraer num_carrera del nombre del archivo (ej: "35_giro-italia.csv" -> num_carrera = 35)
        preg_match('/^(\d+)_/', pathinfo($archivo, PATHINFO_FILENAME), $matches);
        $numCarrera = isset($matches[1]) ? (int) $matches[1] : null;

        if (!$numCarrera) {
            $this->error("No se pudo determinar el num_carrera del archivo: $archivo");
            return;
        }

        $this->info("Procesando inscripciones para la carrera num: $numCarrera");

        // Obtener el número de etapas de la carrera
        $numEtapas = DB::table('carreras')
            ->where('num_carrera', $numCarrera)
            ->where('temporada', $temporada)
            ->value('num_etapas');

        if (!$numEtapas) {
            $this->warn("No se encontraron etapas para la carrera num: $numCarrera");
            return;
        }

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

                    // Insertar inscripciones en la tabla resultados
                    for ($etapa = 1; $etapa <= $numEtapas; $etapa++) {
                        Resultado::updateOrCreate(
                            [
                                'temporada' => $temporada,
                                'num_carrera' => $numCarrera,
                                'etapa' => $etapa,
                                'cod_ciclista' => $codCiclista,
                            ],
                            [
                                'cod_equipo' => $codEquipo,
                                'posicion' => 0,
                            ]
                        );
                    }

                    $this->info("Inscripción registrada para: $nombre en num_carrera: $numCarrera");
                }
            }

            fclose($file);
            DB::commit();
            $this->info("Todas las inscripciones se han importado correctamente.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error al importar inscripciones: " . $e->getMessage());
        }
    }
}
