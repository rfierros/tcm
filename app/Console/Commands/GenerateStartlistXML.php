<?php

namespace App\Console\Commands;

use App\Models\Resultado;
use App\Models\Carrera;
use Illuminate\Console\Command;

class GenerateStartlistXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:startlist {carrera_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un archivo XML de convocatoria desde la tabla Resultados para una carrera_id específica.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener parámetros
        $carreraId = $this->argument('carrera_id');

        // Obtener la carrera para recuperar el campo nombre_xml
        $carrera = Carrera::find($carreraId);
        if (!$carrera) {
            $this->error("No se encontró una carrera con ID: $carreraId");
            return Command::FAILURE;
        }

        // Validar si el campo nombre_xml está presente
        $nombreXml = $carrera->nombre_xml ?? 'default';

        // Directorio donde se guardará el archivo XML
        $importDir = storage_path('app/imports');

        // Nombre del archivo de salida
        $outputFile = "$importDir/{$carreraId}.{$nombreXml}.xml";

        // Crear el directorio si no existe
        if (!is_dir($importDir)) {
            if (!mkdir($importDir, 0755, true) && !is_dir($importDir)) {
                $this->error("No se pudo crear el directorio: $importDir");
                return Command::FAILURE;
            }
        }

        // Obtener registros de resultados de la carrera_id para la etapa 1
        $resultados = Resultado::where('carrera_id', $carreraId)
            ->where('etapa', 1)
            ->with(['ciclista', 'equipo']) // Relación con ciclistas y equipos
            ->orderBy('equipo_id')
            ->get();

        if ($resultados->isEmpty()) {
            $this->error("No se encontraron resultados para carrera_id = $carreraId");
            return Command::FAILURE;
        }

        // Crear el XML
        $xml = new \SimpleXMLElement('<startlist />');

        $currentTeamClaveId = null;
        $teamElement = null;

        foreach ($resultados as $resultado) {
            $ciclista = $resultado->ciclista;
            $equipo = $resultado->equipo;

            if (!$ciclista || !$ciclista->clave_id || !$equipo || !$equipo->clave_id) {
                $this->warn("Datos incompletos: Ciclista o equipo no válidos para resultado ID: {$resultado->id}");
                continue;
            }

            // Si cambia el clave_id del equipo, cerramos el equipo anterior y creamos uno nuevo
            if ($currentTeamClaveId !== $equipo->clave_id) {
                $currentTeamClaveId = $equipo->clave_id;
                $teamElement = $xml->addChild('team');
                $teamElement->addAttribute('id', $currentTeamClaveId);
            }

            // Agregar ciclista al equipo actual
            $cyclistElement = $teamElement->addChild('cyclist');
            $cyclistElement->addAttribute('id', $ciclista->clave_id);
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
}
