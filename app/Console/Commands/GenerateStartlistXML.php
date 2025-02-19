<?php

namespace App\Console\Commands;

use App\Models\Resultado;
use App\Models\Inscripcion;
use App\Models\Carrera;
use Illuminate\Console\Command;

class GenerateStartlistXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:startlist {num_carrera}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un archivo XML de convocatoria desde la tabla Resultados para una carrera específica basada en num_carrera.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener parámetros
        $numCarrera = $this->argument('num_carrera');

        // Obtener la carrera para recuperar el campo nombre_xml
        $carrera = Carrera::where('num_carrera', $numCarrera)->first();
        if (!$carrera) {
            $this->error("No se encontró una carrera con num_carrera: $numCarrera");
            return Command::FAILURE;
        }

        // Validar si el campo nombre_xml está presente
        $nombreXml = $carrera->nombre_xml ?? 'default';

        // Directorio donde se guardará el archivo XML
        $exportDir = storage_path('app/exports/startlists');

        // Nombre del archivo de salida
        $outputFile = "$exportDir/{$nombreXml}.xml";

        // Crear el directorio si no existe
        if (!is_dir($exportDir)) {
            if (!mkdir($exportDir, 0755, true) && !is_dir($exportDir)) {
                $this->error("No se pudo crear el directorio: $exportDir");
                return Command::FAILURE;
            }
        }

        // Aplicar Sanciones a Inscripciones Incorrectas
        $this->aplicarSanciones($numCarrera);

        // Obtener registros de resultados de la num_carrera para la etapa 1
        $resultados = Inscripcion::where('num_carrera', $carrera->num_carrera)
            ->whereNull('sancion')
            ->with(['ciclista', 'equipo']) // Relación con ciclistas y equipos
            ->orderBy('cod_equipo')
            ->get();

        if ($resultados->isEmpty()) {
            $this->error("No se encontraron inscripciones para carrera num_carrera = $numCarrera");
            return Command::FAILURE;
        }
        // // Obtener registros de resultados de la num_carrera para la etapa 1
        // $resultados = Resultado::where('num_carrera', $carrera->num_carrera)
        //     ->where('etapa', 1)
        //     ->with(['ciclista', 'equipo']) // Relación con ciclistas y equipos
        //     ->orderBy('cod_equipo')
        //     ->get();

        // if ($resultados->isEmpty()) {
        //     $this->error("No se encontraron resultados para carrera num_carrera = $numCarrera");
        //     return Command::FAILURE;
        // }

        // Crear el XML
        $xml = new \SimpleXMLElement('<startlist />');

        $currentTeamClaveId = null;
        $teamElement = null;

        foreach ($resultados as $resultado) {
            $ciclista = $resultado->ciclista;
            $equipo = $resultado->equipo;

            if (!$ciclista || !$ciclista->cod_ciclista || !$equipo || !$equipo->cod_equipo) {
                $this->warn("Datos incompletos: Ciclista o equipo no válidos para resultado ID: {$resultado->id}");
                continue;
            }

            // Si cambia el cod_equipo del equipo, cerramos el equipo anterior y creamos uno nuevo
            if ($currentTeamClaveId !== $equipo->cod_equipo) {
                $currentTeamClaveId = $equipo->cod_equipo;
                $teamElement = $xml->addChild('team');
                $teamElement->addAttribute('id', $currentTeamClaveId);
            }

            // Agregar ciclista al equipo actual
            $cyclistElement = $teamElement->addChild('cyclist');
            $cyclistElement->addAttribute('id', $ciclista->cod_ciclista);
        }

        // Agregar última etiqueta fija
        $fixedTeam = $xml->addChild('team');
        $fixedTeam->addAttribute('id', '210');
        $fixedCyclist = $fixedTeam->addChild('cyclist');
        $fixedCyclist->addAttribute('id', '14354');

        // Guardar el XML en el archivo de salida
        if ($xml->asXML($outputFile) === false) {
            $this->error("No se pudo escribir el archivo XML en: $outputFile");
            return Command::FAILURE;
        }

        $this->info("Archivo XML generado correctamente en: $outputFile");
        return Command::SUCCESS;
    }

    /**
     * 🔍 Aplica sanciones a las inscripciones que incumplen reglas.
     */
    private function aplicarSanciones($numCarrera)
    {
        // 1. Ciclistas No U24 en carreras U24
        Inscripcion::where('num_carrera', $numCarrera)
            ->whereHas('ciclista', function ($query) {
                $query->where('edad', '>', 24)->orWhere('media', '>=', 75);
            })
            ->whereHas('carrera', function ($query) {
                $query->where('categoria', 'U24');
            })
            ->update(['sancion' => 'u']);

        // 2. Continentales con estadísticas >= 78
        Inscripcion::where('num_carrera', $numCarrera)
            ->whereHas('ciclista', function ($query) {
                $query->where(function ($q) {
                    $q->where('lla', '>=', 78)
                    ->orWhere('mon', '>=', 78)
                    ->orWhere('col', '>=', 78)
                    ->orWhere('cri', '>=', 78)
                    ->orWhere('pro', '>=', 78)
                    ->orWhere('pav', '>=', 78)
                    ->orWhere('spr', '>=', 78)
                    ->orWhere('acc', '>=', 78)
                    ->orWhere('des', '>=', 78)
                    ->orWhere('com', '>=', 78)
                    ->orWhere('ene', '>=', 78)
                    ->orWhere('res', '>=', 78)
                    ->orWhere('rec', '>=', 78);
                });
            })
            ->whereHas('carrera', function ($query) {
                $query->where('categoria', 'Conti');
            })
            ->update(['sancion' => 'c']);

        // 3. Inscripciones en Fechas Coincidentes
        $ciclistasCoincidentes = Inscripcion::whereHas('carrera.etapas', function ($query) { 
                $query->whereIn('dia', function ($subquery) {
                    $subquery->select('dia')
                        ->from('etapas')
                        ->whereIn('num_carrera', function ($innerQuery) {
                            $innerQuery->select('num_carrera')
                                ->from('inscripciones')
                                ->groupBy('cod_ciclista')
                                ->havingRaw('COUNT(DISTINCT num_carrera) > 1');
                        });
                });
            })
            ->pluck('cod_ciclista');

        if ($ciclistasCoincidentes->isNotEmpty()) {
            Inscripcion::whereIn('cod_ciclista', $ciclistasCoincidentes)
                ->update(['sancion' => 'd']);
        }

        $this->info("Sanciones aplicadas correctamente.");
    }
}
