<?php

namespace App\Console\Commands;

use App\Models\Ciclista;
use App\Models\Resultado;
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
        $importDir = storage_path('app/imports');
        $files = glob("$importDir/*.ins");

        if (empty($files)) {
            $this->warn("No se encontraron archivos .ins en el directorio: $importDir");
            return;
        }

        DB::beginTransaction();

        try {
            // Cargar todos los equipos de la temporada en un array
            $equipos = Ciclista::where('temporada', $temporada)->pluck('equipo_id', 'nom_ape')->toArray();

            foreach ($files as $filePath) {
                // Obtener el carrera_id del nombre del archivo (ej: "1.ins" -> carrera_id = 1)
                $carreraId = (int) pathinfo($filePath, PATHINFO_FILENAME);
                $this->info("Procesando inscripciones para la carrera Id: $carreraId");

                $file = fopen($filePath, 'r');

                // Obtener el número de etapas de la carrera
                $numEtapas = DB::table('etapas')->where('carrera_id', $carreraId)->count();

                if ($numEtapas === 0) {
                    $this->warn("No se encontraron etapas para la carrera ID: $carreraId");
                    fclose($file);
                    continue;
                }

                // Leer el archivo línea por línea
                while (($nomApe = fgets($file)) !== false) {
                    $nomApe = trim($nomApe);

                    // Buscar el ciclista en la base de datos
                    $ciclista = Ciclista::where('nom_ape', $nomApe)
                        ->where('temporada', $temporada)
                        ->first();

                    if (!$ciclista) {
                        $this->warn("Ciclista no encontrado: $nomApe");
                        continue;
                    }

                    // Obtener los datos del ciclista
                    $ciclistaId = $ciclista->id;
                    $equipoId = $ciclista->equipo_id;

                    // Insertar un registro en la tabla resultados para cada etapa
                    for ($etapa = 1; $etapa <= $numEtapas; $etapa++) {
                        Resultado::updateOrCreate(
                            [
                                'temporada' => $temporada,
                                'carrera_id' => $carreraId,
                                'etapa' => $etapa,
                                'ciclista_id' => $ciclistaId,
                            ],
                            [
                                'equipo_id' => $equipoId,
                                'posicion' => 0,
                            ]
                        );
                    }

                    $this->info("Inscripción registrada para: $nomApe en carrera ID: $carreraId");
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
