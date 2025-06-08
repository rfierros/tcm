<?php

namespace Database\Seeders;

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
        $temporada = 4;

        // Array de carreras con sus etapas
        $carreras = [
            [
                'num_carrera' => 35, // Giro de Italia
                'etapas' => [
                    ['num_etapa' => 1, 'nombre' => 'Herning', 'km' => 8, 'perfil' => 'llano',        'tipo' => 'cri'],
                    ['num_etapa' => 2, 'nombre' => 'Herning - Herning', 'km' => 195, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 3, 'nombre' => 'Horsens - Horsens', 'km' => 190, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 4, 'nombre' => 'Verona - Verona', 'km' => 30, 'perfil' => 'llano',        'tipo' => 'cre'],
                    ['num_etapa' => 5, 'nombre' => 'Modena - Fano', 'km' => 197, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 6, 'nombre' => 'Urbino - Porto Sant Elpidio', 'km' => 206, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
                    ['num_etapa' => 7, 'nombre' => 'Recanati - Rocca di Cambio', 'km' => 203, 'perfil' => 'montaña',       'tipo' => 'normal'],
                    ['num_etapa' => 8, 'nombre' => 'Sulmona - Lago Laceno', 'km' => 229, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
                    ['num_etapa' => 9, 'nombre' => 'San Giorgio del Sannio - Frosinone', 'km' => 175, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 10, 'nombre' => 'Civitavecchia - Assisi', 'km' => 190, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
                    ['num_etapa' => 11, 'nombre' => 'Assisi - Montecatini Terme', 'km' => 242, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 12, 'nombre' => 'Seravezza - Sestri Levante', 'km' => 151, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
                    ['num_etapa' => 13, 'nombre' => 'Savona - Cervere', 'km' => 122, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 14, 'nombre' => 'Cherasco - Cervinia', 'km' => 201, 'perfil' => 'montaña',       'tipo' => 'normal'],
                    ['num_etapa' => 15, 'nombre' => 'Busto Arsizio - Lecco Pian dei Resinelli', 'km' => 169, 'perfil' => 'media-montaña', 'tipo' => 'normal'],
                    ['num_etapa' => 16, 'nombre' => 'Limone sul Garda - Falzes', 'km' => 173, 'perfil' => 'montaña',       'tipo' => 'normal'],
                    ['num_etapa' => 17, 'nombre' => 'Falzes - Cortina D Ampezzo', 'km' => 184, 'perfil' => 'montaña',       'tipo' => 'normal'],
                    ['num_etapa' => 18, 'nombre' => 'San Vito di Cadore - Vedelago', 'km' => 136, 'perfil' => 'llano',        'tipo' => 'normal'],
                    ['num_etapa' => 19, 'nombre' => 'Treviso - Alpe di Pampeago Val di Fiemme', 'km' => 193, 'perfil' => 'montaña',       'tipo' => 'normal'],
                    ['num_etapa' => 20, 'nombre' => 'Caldes Val di Sole - Passo dello Stelvio', 'km' => 215, 'perfil' => 'montaña',       'tipo' => 'normal'],
                    ['num_etapa' => 21, 'nombre' => 'Milano - Milano', 'km' => 30, 'perfil' => 'llano',        'tipo' => 'cri'],
                ],
            ],
            [
                'num_carrera' => 43, // Tour de Francia
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 199, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Passage du Gois - Mont des Alouettes'],
                    ['num_etapa' =>  2, 'km' =>  23, 'perfil' => 'llano', 'tipo' => 'cre', 'nombre' => 'Les Essarts - Les Essarts'],
                    ['num_etapa' =>  3, 'km' => 191, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Olonne-sur-Mer - Redon'],
                    ['num_etapa' =>  4, 'km' => 165, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Lorient - Mûr-de-Bretagne'],
                    ['num_etapa' =>  5, 'km' => 165, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Carhaix - Cap Fréhel'],
                    ['num_etapa' =>  6, 'km' => 222, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Dinan - Lisieux'],
                    ['num_etapa' =>  7, 'km' => 219, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Le Mans - Châteauroux'],
                    ['num_etapa' =>  8, 'km' => 185, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Aigurande - Super-Besse Sancy'],
                    ['num_etapa' =>  9, 'km' => 200, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Issoire - Saint-Flour'],
                    ['num_etapa' => 10, 'km' => 144, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Aurillac - Carmaux'],
                    ['num_etapa' => 11, 'km' => 157, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Blaye-les-Mines - Lavaur'],
                    ['num_etapa' => 12, 'km' => 208, 'perfil' => 'montaña', 'tipo' => 'normal', 'nombre' => 'Cugnaux - Luz-Ardiden'],
                    ['num_etapa' => 13, 'km' => 146, 'perfil' => 'montaña', 'tipo' => 'normal', 'nombre' => 'Pau - Lourdes'],
                    ['num_etapa' => 14, 'km' => 159, 'perfil' => 'montaña', 'tipo' => 'normal', 'nombre' => 'Saint-Gaudens - Plateau de Beille'],
                    ['num_etapa' => 15, 'km' => 185, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Limoux - Montpellier'],
                    ['num_etapa' => 16, 'km' => 162, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Saint-Paul-Trois-Châteaux - Gap'],
                    ['num_etapa' => 17, 'km' => 179, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Gap - Pinerolo'],
                    ['num_etapa' => 18, 'km' => 180, 'perfil' => 'montaña', 'tipo' => 'normal', 'nombre' => 'Pinerolo - Galibier Serre-Chevalier'],
                    ['num_etapa' => 19, 'km' => 110, 'perfil' => 'montaña', 'tipo' => 'normal', 'nombre' => 'Modane - Alpe-d\'Huez'],
                    ['num_etapa' => 20, 'km' =>  41, 'perfil' => 'media-montaña', 'tipo' => 'cri', 'nombre' => 'Grenoble - Grenoble'],
                    ['num_etapa' => 21, 'km' => 141, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Créteil - Paris Champs-Élysées'],

                ],
            ],
            [
                'num_carrera' => 54, // Vuelta a España
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 8.4, 'perfil' => 'media-montaña', 'tipo' => 'cri',    'nombre' => 'Málaga - Málaga'],
                    ['num_etapa' =>  2, 'km' => 165, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Marbella - Caminito del Rey'],
                    ['num_etapa' =>  3, 'km' => 175, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Mijas - Alhaurín de la Torre'],
                    ['num_etapa' =>  4, 'km' => 160, 'perfil' => 'montaña',       'tipo' => 'normal', 'nombre' => 'Vélez-Málaga - Sierra de la Alfaguara'],
                    ['num_etapa' =>  5, 'km' => 189, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Granada - Roquetas de Mar'],
                    ['num_etapa' =>  6, 'km' => 149, 'perfil' => 'llano',         'tipo' => 'normal', 'nombre' => 'Huércal-Overa - San Javier'],
                    ['num_etapa' =>  7, 'km' => 185, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Puerto Lumbreras - Pozo Alcón'],
                    ['num_etapa' =>  8, 'km' => 195, 'perfil' => 'llano',         'tipo' => 'normal', 'nombre' => 'Linares - Almadén'],
                    ['num_etapa' =>  9, 'km' => 196, 'perfil' => 'montaña',       'tipo' => 'normal', 'nombre' => 'Talavera de la Reina - La Covatilla'],
                    ['num_etapa' => 10, 'km' => 172, 'perfil' => 'llano',         'tipo' => 'normal', 'nombre' => 'Salamanca - Fermoselle'],
                    ['num_etapa' => 11, 'km' => 215, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Mombuey - Luintra'],
                    ['num_etapa' => 12, 'km' => 175, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Mondoñedo - Faro de Estaca de Bares'],
                    ['num_etapa' => 13, 'km' => 173, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Candás - La Camperona'],
                    ['num_etapa' => 14, 'km' => 170, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Cistierna - Les Praeres'],
                    ['num_etapa' => 15, 'km' => 169, 'perfil' => 'montaña',       'tipo' => 'normal', 'nombre' => 'Ribera de Arriba - Lagos de Covadonga'],
                    ['num_etapa' => 16, 'km' =>  32, 'perfil' => 'llano',         'tipo' => 'cri',    'nombre' => 'Santillana del Mar - Torrelavega'],
                    ['num_etapa' => 17, 'km' => 163, 'perfil' => 'montaña',       'tipo' => 'normal', 'nombre' => 'Getxo - Balcón de Bizkaia'],
                    ['num_etapa' => 18, 'km' => 182, 'perfil' => 'llano',         'tipo' => 'normal', 'nombre' => 'Ejea de los Caballeros - Lleida'],
                    ['num_etapa' => 19, 'km' => 157, 'perfil' => 'montaña',       'tipo' => 'normal', 'nombre' => 'Lleida - Andorra. Naturlandia'],
                    ['num_etapa' => 20, 'km' => 101, 'perfil' => 'montaña',       'tipo' => 'normal', 'nombre' => 'Andorra - Coll de la Gallina'],
                    ['num_etapa' => 21, 'km' => 103, 'perfil' => 'llano',         'tipo' => 'normal', 'nombre' => 'Alcorcón - Madrid'],
                ],
            ],
            //Monumentos
            [
                'num_carrera' => 17, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 299, 'perfil' => 'media-montaña', 'tipo' => 'normal',    'nombre' => 'Milano - San Remo'],
                ],
            ],
            [
                'num_carrera' => 24, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 232, 'perfil' => 'llano', 'tipo' => 'normal',    'nombre' => 'Ronde van Vlaanderen'],
                ],
            ],
            [
                'num_carrera' => 26, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 261, 'perfil' => 'llano', 'tipo' => 'normal',    'nombre' => 'Paris - Roubaix'],
                ],
            ],
            [
                'num_carrera' => 31, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 254, 'perfil' => 'media-montaña', 'tipo' => 'normal',    'nombre' => 'Liege - Bastogne - Liege'],
                ],
            ],
            [
                'num_carrera' => 64, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 233, 'perfil' => 'montaña', 'tipo' => 'normal',    'nombre' => 'Il Lombardia'],
                ],
            ],
            // Clásicas WT
            [
                'num_carrera' => 3, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 172, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Cadel Evans'],
                ],
            ],
            [
                'num_carrera' => 10, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 201, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Omloop'],
                ],
            ],
            [
                'num_carrera' => 11, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 213, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Strade Bianche'],
                ],
            ],
            [
                'num_carrera' => 19, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 213, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'De Panne'],
                ],
            ],
            [
                'num_carrera' => 20, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 202, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'E3'],
                ],
            ],
            [
                'num_carrera' => 22, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 174, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Gent-Wevelgem'],
                ],
            ],
            [
                'num_carrera' => 29, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 256, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Dwars'],
                ],
            ],
            [
                'num_carrera' => 30, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 199, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Amstel'],
                ],
            ],
            [
                'num_carrera' => 34, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 214, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Flecha'],
                ],
            ],
            [
                'num_carrera' => 51, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 215, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Frankfurt'],
                ],
            ],
            [
                'num_carrera' => 56, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 260, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'San Sebastián'],
                ],
            ],
            [
                'num_carrera' => 58 , 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 219, 'perfil' => 'llano', 'tipo' => 'normal', 'nombre' => 'Bremer'],
                ],
            ],
            [
                'num_carrera' => 59, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 204, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Québec'],
                ],
            ],
            [
                'num_carrera' => 61, 
                'etapas' => [
                    ['num_etapa' =>  1, 'km' => 199, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'nombre' => 'Montreal'],
                ],
            ],

        ];

        foreach ($carreras as $carreraData) {
            $numCarrera = $carreraData['num_carrera'];
            $carrera = Carrera::find($numCarrera);

            if (!$carrera) {
                $this->command->warn("Carrera no encontrada con ID: $numCarrera");
                continue;
            }

            $slugCarrera = $carrera->slug;

            foreach ($carreraData['etapas'] as $etapa) {
                // Actualizar o insertar las etapas existentes para la carrera especificada
                Etapa::updateOrInsert(
                    [
                        'num_carrera' => $numCarrera,
                        'num_etapa' => $etapa['num_etapa'],
                        'temporada' => $temporada,
                    ],
                    [
                        'nombre' => $etapa['nombre'],
                        'slug' => $slugCarrera,
                        'km' => $etapa['km'],
                        'perfil' => $etapa['perfil'],
                        'tipo' => $etapa['tipo'],
                        'imagen' => null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        $this->command->info("Las etapas de las carreras se han actualizado correctamente.");
    }
}
