<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Resultado;
use App\Models\Inscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportInscripciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:inscripciones {temporada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar inscripciones de corredores para todas las carreras desde archivos .ins en el directorio de imports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $temporada = $this->argument('temporada');

        // Directorio donde están los archivos .ins
        $importDir = storage_path('app/imports/inscripciones/{$temporada}');
        $files = glob("$importDir/*.ins");

        if (empty($files)) {
            $this->warn("No se encontraron archivos .ins en el directorio: $importDir");
            return;
        }

        DB::beginTransaction();

        try {
            // Cargar todos los equipos de la temporada en un array
            $equipos = Ciclista::where('temporada', $temporada)->pluck('cod_equipo', 'nom_abrev')->toArray();

            foreach ($files as $filePath) {
                // Extraer el num_carrera del nombre del archivo (ej: "35.giro-italia.ins" -> num_carrera = 35)
                preg_match('/^(\d+)\./', pathinfo($filePath, PATHINFO_FILENAME), $matches);
                $numCarrera = isset($matches[1]) ? (int) $matches[1] : null;

                if (!$numCarrera) {
                    $this->warn("El archivo no tiene un formato válido para obtener el num_carrera: $filePath");
                    continue;
                }

                $this->info("Procesando inscripciones para la carrera num: $numCarrera");

                $file = fopen($filePath, 'r');

                // Obtener el número de etapas de la carrera
                $numEtapas = DB::table('etapas')->where('num_carrera', $numCarrera)->count();

                if ($numEtapas === 0) {
                    $this->warn("No se encontraron etapas para la carrera num: $numCarrera");
                    fclose($file);
                    continue;
                }

                // Leer el archivo línea por línea
                while (($nomApe = fgets($file)) !== false) {
                    $nomApe = trim($nomApe);

                    // Buscar el ciclista en la base de datos
                    $ciclista = Ciclista::where('nom_abrev', $nomApe)
                        ->where('temporada', $temporada)
                        ->first();

                    if (!$ciclista) {
                        $this->warn("Ciclista no encontrado: $nomApe");
                        continue;
                    }

                    // Obtener los datos del ciclista
                    $codCiclista = $ciclista->cod_ciclista;
                    $codEquipo = $ciclista->cod_equipo;

                    // Insertar un registro en la tabla resultados para cada etapa
                    // for ($etapa = 1; $etapa <= $numEtapas; $etapa++) {
                    //     Resultado::updateOrCreate(
                    //         [
                    //             'temporada' => $temporada,
                    //             'num_carrera' => $numCarrera, // Asegúrate de incluir esta clave
                    //             'etapa' => $etapa,
                    //             'cod_ciclista' => $codCiclista,
                    //         ],
                    //         [
                    //             'cod_equipo' => $codEquipo,
                    //             'posicion' => 0,
                    //         ]
                    //     );
                    // }

                    $this->info("Inscripción (resultado) registrada para: $nomApe en num_carrera: $numCarrera");

                    // Insertar un registro en la tabla incripciones para cada etapa
                    for ($etapa = 1; $etapa <= $numEtapas; $etapa++) {
                        Inscripcion::updateOrCreate(
                            [
                                'temporada' => $temporada,
                                'num_carrera' => $numCarrera, // Asegúrate de incluir esta clave
                                'cod_ciclista' => $codCiclista,
                            ],
                            [
                                'cod_equipo' => $codEquipo,
                            ]
                        );
                    }

                    $this->info("--> Inscripción ins: $nomApe en num_carrera: $numCarrera");
                }

                fclose($file);
            }

            DB::commit();
            $this->info("Todas las inscripciones se han importado correctamente.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error al importar inscripciones: " . $e->getMessage());
        }
    }
}
