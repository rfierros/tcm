<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Etapa;
use App\Models\Carrera;

class EtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $carreras = Carrera::all();

        foreach ($carreras as $carrera) {
            for ($i = 1; $i <= $carrera->num_etapas; $i++) {
                Etapa::create([
                    'carrera_id' => $carrera->id,
                    'temporada' => $carrera->temporada,
                    'num_etapa' => $i, //Numero de etapa
                    'dia' => $carrera->dia_inicio + $i - 1, // Día de la etapa
                    'perfil' => null,
                    'imagen' => null
                ]);
            }
        }
    }
}
