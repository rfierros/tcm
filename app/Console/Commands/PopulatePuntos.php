<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulatePuntos extends Command
{
    protected $signature = 'populate:puntos-from-json';

    protected $description = 'Genera registros en la tabla puntos usando configuraciones desde un archivo JSON.';

    public function handle(): void
    {
        $filePath = config_path('puntos.json');

        if (!file_exists($filePath)) {
            $this->error("El archivo $filePath no existe.");
            return;
        }

        $json = file_get_contents($filePath);
        $configurations = json_decode($json, true);

        if (!$configurations || !is_array($configurations)) {
            $this->error("El archivo JSON no tiene un formato válido.");
            return;
        }

        $temporada = config('tcm.temporada');
        $totalInserted = 0;

        foreach ($configurations as $config) {
            if (!isset($config['categoria'], $config['tipo'], $config['clasificacion'], $config['valorInicial'], $config['diferencial'], $config['posicionInicial'], $config['n'])) {
                $this->warn("Configuración incompleta: " . json_encode($config));
                continue;
            }

            $categoria = $config['categoria'];
            $tipo = $config['tipo'];
            $clasificacion = $config['clasificacion'];
            $valorInicial = (float) $config['valorInicial'];
            $diferencial = (float) $config['diferencial'];
            $posicionInicial = (int) $config['posicionInicial'];
            $n = (int) $config['n'];

            $valoresEspeciales = $config['valoresEspeciales'] ?? [];

            $data = [];

            // Insertar los valores especiales
            foreach ($valoresEspeciales as $posicion => $pts) {
                $data[] = [
                    'temporada' => $temporada,
                    'posicion' => (int)$posicion,
                    'categoria' => $categoria,
                    'tipo' => $tipo,
                    'clasificacion' => $clasificacion,
                    'pts' => (float)$pts,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insertar los valores de la progresión aritmética
            for ($i = 0; $i < $n; $i++) {
                $posicion = $posicionInicial + $i;

                // Si la posición ya está definida en los valores especiales, saltarla
                if (isset($valoresEspeciales[$posicion])) {
                    continue;
                }

                $pts = max($valorInicial - ($diferencial * $i), 0);

                $data[] = [
                    'temporada' => $temporada,
                    'posicion' => $posicion,
                    'categoria' => $categoria,
                    'tipo' => $tipo,
                    'clasificacion' => $clasificacion,
                    'pts' => $pts,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insertar en la base de datos
            DB::table('puntos')->insert($data);
            $totalInserted += count($data);

            $this->info("Generados " . count($data) . " registros para {$categoria} - {$tipo} - {$clasificacion}.");
        }

        $this->info("Proceso completado. Total de registros insertados: $totalInserted.");
    }
}
