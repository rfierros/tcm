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
    public function run()
    {
        // Definir carreras y sus detalles
        $carreras = [
            [
                'nombre' => 'New Zealand Cycle Classic',
                'temporada' => 4,
                'dia_inicio' => 8,
                'num_etapas' => 5
            ],
            [
                'nombre' => 'Down Under',
                'temporada' => 4,
                'dia_inicio' => 9,
                'num_etapas' => 6
            ],
            [
                'nombre' => 'Clàssica C. Valenciana',
                'temporada' => 4,
                'dia_inicio' => 14,
                'num_etapas' => 1
            ],
        ];

        foreach ($carreras as $carreraData) {
            // Obtener la carrera correspondiente
            $carrera = Carrera::where('nombre', $carreraData['nombre'])
                              ->where('temporada', $carreraData['temporada'])
                              ->first();

            // Generar cada día de la carrera en el calendario
            for ($etapa = 1; $etapa <= $carreraData['num_etapas']; $etapa++) {
                Calendario::create([
                    'carrera_id' => $carrera->id,
                    'temporada' => $carreraData['temporada'],
                    'dia' => $carreraData['dia_inicio'] + $etapa - 1, // Calcula el día de competición en el calendario
                    'etapa' => $etapa,
                ]);
            }
        }
    }
}

