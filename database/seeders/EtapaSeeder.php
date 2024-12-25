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
                    'temporada' => $carrera->temporada,
                    'num_carrera' => $carrera->num_carrera,
                    'num_etapa' => $i, //Numero de etapa
                    'slug' => $carrera->slug,
                    'nombre' => null,
                    'km' => null,
                    'dia' => $carrera->dia_inicio + $i - 1, // Día de la etapa
                    'perfil' => null,
                    'tipo' => null,
                    'imagen' => null
                ]);
            }
        }

        // Seeder para update del Gito
        $carreraId = 35; // Giro de Italia

        $etapas = [
            ['num_etapa' => 1, 'nombre' => 'Herning', 'km' => 8, 'perfil' => 'llano', 'tipo' => 'cri'],
            ['num_etapa' => 2, 'nombre' => 'Herning - Herning', 'km' => 195, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 3, 'nombre' => 'Horsens - Horsens', 'km' => 190, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 4, 'nombre' => 'Verona - Verona', 'km' => 30, 'perfil' => 'llano', 'tipo' => 'cre'],
            ['num_etapa' => 5, 'nombre' => 'Modena - Fano', 'km' => 197, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 6, 'nombre' => 'Urbino - Porto Sant Elpidio', 'km' => 206, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
            ['num_etapa' => 7, 'nombre' => 'Recanati - Rocca di Cambio', 'km' => 203, 'perfil' => 'montaña', 'tipo' => 'normal'],
            ['num_etapa' => 8, 'nombre' => 'Sulmona - Lago Laceno', 'km' => 229, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
            ['num_etapa' => 9, 'nombre' => 'San Giorgio del Sannio - Frosinone', 'km' => 175, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 10, 'nombre' => 'Civitavecchia - Assisi', 'km' => 190, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
            ['num_etapa' => 11, 'nombre' => 'Assisi - Montecatini Terme', 'km' => 242, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 12, 'nombre' => 'Seravezza - Sestri Levante', 'km' => 151, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
            ['num_etapa' => 13, 'nombre' => 'Savona - Cervere', 'km' => 122, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 14, 'nombre' => 'Cherasco - Cervinia', 'km' => 201, 'perfil' => 'montaña', 'tipo' => 'normal'],
            ['num_etapa' => 15, 'nombre' => 'Busto Arsizio - Lecco Pian dei Resinelli', 'km' => 169, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
            ['num_etapa' => 16, 'nombre' => 'Limone sul Garda - Falzes', 'km' => 173, 'perfil' => 'montaña', 'tipo' => 'normal'],
            ['num_etapa' => 17, 'nombre' => 'Falzes - Cortina D Ampezzo', 'km' => 184, 'perfil' => 'montaña', 'tipo' => 'normal'],
            ['num_etapa' => 18, 'nombre' => 'San Vito di Cadore - Vedelago', 'km' => 136, 'perfil' => 'llano', 'tipo' => 'normal'],
            ['num_etapa' => 19, 'nombre' => 'Treviso - Alpe di Pampeago Val di Fiemme', 'km' => 193, 'perfil' => 'montaña', 'tipo' => 'normal'],
            ['num_etapa' => 20, 'nombre' => 'Caldes Val di Sole - Passo dello Stelvio', 'km' => 215, 'perfil' => 'montaña', 'tipo' => 'normal'],
            ['num_etapa' => 21, 'nombre' => 'Milano - Milano', 'km' => 30, 'perfil' => 'llano', 'tipo' => 'cri'],
        ];

  
            foreach ($etapas as $etapa) {
                // Buscar la etapa existente y actualizarla
                Etapa::where('num_carrera', 35)
                    ->where('num_etapa', $etapa['num_etapa'])
                    ->where('temporada', 4)
                    ->update([
                        'nombre' => $etapa['nombre'],
                        'km' => $etapa['km'],
                        'perfil' => $etapa['perfil'],
                        'tipo' => $etapa['tipo'],
                        'imagen' => null,
                    ]);
            }
        // Seeder para update del Gito
    }
}
