<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Calendario;
use App\Models\Carrera;

// Para hacer correr este seeder basta con:
// php artisan db:seed --class=CalendarioSeeder
class CalendarioSeeder extends Seeder
{
    /*
    Para generar los calendarios a partir de las Carreras de una temporada solo tenemos que lanzar uno de estos 2 procesos.
    El primero (run) deberíamos modificar a mano la temporada, especificada dentro del propio proceso.
    La segunda opción (runWithTemporada) es más elegante pero debemos lanzarla a través de tinker.
        php artisan tinker
        $seeder = new Database\Seeders\CalendarioSeeder();
        $seeder->runWithTemporada(4);
    */
    public function run()
    {
        $temporada = 4;
        // Obtener todas las carreras de la temporada 4
        $carreras = Carrera::where('temporada', $temporada)->get();

        foreach ($carreras as $carrera) {
            // Generar un registro en Calendario para cada día de la carrera
            for ($etapa = 1; $etapa <= $carrera->num_etapas; $etapa++) {
                Calendario::create([
                    'carrera_id' => $carrera->id,
                    'dia' => $carrera->dia_inicio + $etapa - 1, // Día específico de la etapa
                    'temporada' => $carrera->temporada,
                    'etapa' => $etapa,
                ]);
            }
        }
    }

    public function runWithTemporada($temporada)
    {
        // Comprobar si ya existen registros para la temporada
        if (Calendario::where('temporada', $temporada)->exists()) {
            echo "Ya existen registros en la temporada {$temporada} en la tabla Calendario. Operación cancelada.\n";
            return;
        }

        // Obtener todas las carreras de la temporada especificada
        $carreras = Carrera::where('temporada', $temporada)->get();

        foreach ($carreras as $carrera) {
            // Generar un registro en Calendario para cada día de la carrera
            for ($etapa = 1; $etapa <= $carrera->num_etapas; $etapa++) {
                Calendario::create([
                    'carrera_id' => $carrera->id,
                    'dia' => $carrera->dia_inicio + $etapa - 1, // Día específico de la etapa
                    'temporada' => $carrera->temporada,
                    'etapa' => $etapa,
                ]);
            }
        }

        echo "Datos de la temporada {$temporada} insertados correctamente en la tabla Calendario.\n";
    }
}

