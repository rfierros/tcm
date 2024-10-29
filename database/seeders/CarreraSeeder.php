<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    public function run()
    {
        Carrera::create([
            'nombre' => 'New Zealand Cycle Classic',
            'num_etapas' => 5,
            'dia_inicio' => 8,
            'tipo' => 'Vuelta',
            'categoria' => 'U24',
            'temporada' => 4,
        ]);

        Carrera::create([
            'nombre' => 'Down Under',
            'num_etapas' => 6,
            'dia_inicio' => 9,
            'tipo' => 'Vuelta',
            'categoria' => 'WT',
            'temporada' => 4,
        ]);

        Carrera::create([
            'nombre' => 'Clàssica C. Valenciana',
            'num_etapas' => 1,
            'dia_inicio' => 14,
            'tipo' => 'Clasica',
            'categoria' => 'Conti',
            'temporada' => 4,
        ]);
    }
}
