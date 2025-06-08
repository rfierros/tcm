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

        // creamos todas las etapas existentes segun el calendario de carreras, con todo vacío, y después lo completaremos con info específica.
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

        // Temporada 5
        $etapas = [
            // CLASICAS
            ['num_carrera' => 3, 'num_etapa' => 1, 'nombre' => 'Castellón de la plana - Onda', 'km' => 176, 'perfil' => 'media-montaña', 'paves' => 0], // Ruta de la cerámica
            ['num_carrera' => 4, 'num_etapa' => 1, 'nombre' => 'Geelong - Geelong', 'km' => 171, 'perfil' => 'llano', 'paves' => 0], // Cadel Evans Great Ocean Road Race
            ['num_carrera' => 7, 'num_etapa' => 1, 'nombre' => 'São Pedro (Figueira da Foz) - Figueira da Foz', 'km' => 218, 'perfil' => 'llano', 'paves' => 0], // Figueira Champions Classic
            ['num_carrera' => 11, 'num_etapa' => 1, 'nombre' => 'Gent - Gent', 'km' => 197, 'perfil' => 'llano', 'paves' => 2], // Omloop Het Nieuwsblad
            ['num_carrera' => 12, 'num_etapa' => 1, 'nombre' => 'San Gimignano - Siena', 'km' => 202, 'perfil' => 'media-montaña', 'paves' => 3], // Strade Bianche
            ['num_carrera' => 14, 'num_etapa' => 1, 'nombre' => 'Lillers - Lillers', 'km' => 179, 'perfil' => 'llano', 'paves' => 0], // GP de la Ville de Lillers
            ['num_carrera' => 18, 'num_etapa' => 1, 'nombre' => 'La Haye-Fouassière - La Haye-Fouassière', 'km' => 181, 'perfil' => 'llano', 'paves' => 0], // Classic Loire
            ['num_carrera' => 19, 'num_etapa' => 1, 'nombre' => 'Milano - Sanremo', 'km' => 303, 'perfil' => 'llano', 'paves' => 0], // Milano - Sanremo
            ['num_carrera' => 21, 'num_etapa' => 1, 'nombre' => 'De Panne - Zottegem', 'km' => 188, 'perfil' => 'llano', 'paves' => 1], // AG Driedaagse Brugge-De Panne
            ['num_carrera' => 23, 'num_etapa' => 1, 'nombre' => 'Harelbeke - Harelbeke', 'km' => 203, 'perfil' => 'llano', 'paves' => 2], // E3 BinckBank Classic
            ['num_carrera' => 24, 'num_etapa' => 1, 'nombre' => 'Gent - Wevelgem', 'km' => 236, 'perfil' => 'llano', 'paves' => 2], // Gent-Wevelgem in Flanders Fields
            ['num_carrera' => 25, 'num_etapa' => 1, 'nombre' => 'Roeselare - Waregem', 'km' => 174, 'perfil' => 'llano', 'paves' => 2], // Dwars door Vlaanderen
            ['num_carrera' => 26, 'num_etapa' => 1, 'nombre' => 'Antwerpen - Oudenaarde', 'km' => 247, 'perfil' => 'llano', 'paves' => 3], // Ronde van Vlaanderen
            ['num_carrera' => 27, 'num_etapa' => 1, 'nombre' => 'Col San Martino - Col San Martino', 'km' => 179, 'perfil' => 'media-montaña', 'paves' => 0], // Trofeo PIVA
            ['num_carrera' => 29, 'num_etapa' => 1, 'nombre' => 'Compiègne - Roubaix', 'km' => 258, 'perfil' => 'llano', 'paves' => 4], // Paris - Roubaix
            ['num_carrera' => 31, 'num_etapa' => 1, 'nombre' => 'Maastricht - Valkenburg', 'km' => 251, 'perfil' => 'media-montaña', 'paves' => 0], // Amstel Gold Race
            ['num_carrera' => 32, 'num_etapa' => 1, 'nombre' => 'Bastogne - Huy', 'km' => 197, 'perfil' => 'media-montaña', 'paves' => 0], // La Flèche Wallonne
            ['num_carrera' => 33, 'num_etapa' => 1, 'nombre' => 'Liège - Liège', 'km' => 258, 'perfil' => 'media-montaña', 'paves' => 0], // Liège - Bastogne - Liège
            ['num_carrera' => 35, 'num_etapa' => 1, 'nombre' => 'Eschborn - Frankfurt', 'km' => 197, 'perfil' => 'llano', 'paves' => 0], // Eschborn-Frankfurt
            ['num_carrera' => 36, 'num_etapa' => 1, 'nombre' => 'S. Vicente Barquera - Alto del Naranco', 'km' => 175, 'perfil' => 'media-montaña', 'paves' => 0], // Subida al Naranco
            ['num_carrera' => 37, 'num_etapa' => 1, 'nombre' => 'Péronne - Roubaix', 'km' => 193, 'perfil' => 'llano', 'paves' => 3], // Paris - Roubaix Espoirs
            ['num_carrera' => 40, 'num_etapa' => 1, 'nombre' => 'Les Herbiers - Les Herbiers', 'km' => 32, 'perfil' => 'llano', 'paves' => 0], // Chrono des Nations U23
            ['num_carrera' => 42, 'num_etapa' => 1, 'nombre' => 'Kortrijk - Zwevegem', 'km' => 190, 'perfil' => 'llano', 'paves' => 2], // Marcel Kint Classic
            ['num_carrera' => 44, 'num_etapa' => 1, 'nombre' => 'Star - Eagle', 'km' => 22, 'perfil' => 'llano', 'paves' => 0, 'tipo' => 'cri'], // Chrono Kristin Armstrong
            ['num_carrera' => 45, 'num_etapa' => 1, 'nombre' => 'Colombey-les-deux-Églises - Troyes', 'km' => 185, 'perfil' => 'llano', 'paves' => 0], // Paris - Troyes
            ['num_carrera' => 47, 'num_etapa' => 1, 'nombre' => 'Vaison-la-Romaine - Mont Ventoux', 'km' => 164, 'perfil' => 'montaña', 'paves' => 0], // CIC - Mont Ventoux
            ['num_carrera' => 49, 'num_etapa' => 1, 'nombre' => 'Copenhagen - Rudersdal', 'km' => 264, 'perfil' => 'llano', 'paves' => 0], // Copenhagen Sprint
            ['num_carrera' => 51, 'num_etapa' => 1, 'nombre' => 'Zottegem - Zottegem', 'km' => 175, 'perfil' => 'llano', 'paves' => 2], // Omloop Het Nieuwsblad Beloften
            ['num_carrera' => 52, 'num_etapa' => 1, 'nombre' => 'Nová Bana - Nová Bana', 'km' => 136, 'perfil' => 'media-montaña', 'paves' => 0], // Visegrad 4 Bicycle Race - GP Slovakia
            ['num_carrera' => 54, 'num_etapa' => 1, 'nombre' => 'Pedara - Messina', 'km' => 155, 'perfil' => 'llano', 'paves' => 0], // Trofeo dell'Etna
            ['num_carrera' => 55, 'num_etapa' => 1, 'nombre' => 'San Sebastian - San Sebastian', 'km' => 231, 'perfil' => 'media-montaña', 'paves' => 0], // Clasica Ciclista San Sebastian
            ['num_carrera' => 57, 'num_etapa' => 1, 'nombre' => 'Getxo - Getxo', 'km' => 193, 'perfil' => 'llano', 'paves' => 0], // circuito de Getxo
            ['num_carrera' => 59, 'num_etapa' => 1, 'nombre' => 'Overijse - Overijse', 'km' => 183, 'perfil' => 'llano', 'paves' => 0], // Druivenkoers
            ['num_carrera' => 60, 'num_etapa' => 1, 'nombre' => 'Hamburg - Hamburg', 'km' => 219, 'perfil' => 'llano', 'paves' => 0], // BEMER Cyclassics
            ['num_carrera' => 61, 'num_etapa' => 1, 'nombre' => 'Kranj - Kranj', 'km' => 156, 'perfil' => 'llano', 'paves' => 0], // GP Kranj
            ['num_carrera' => 64, 'num_etapa' => 1, 'nombre' => 'Plouay - Plouay', 'km' => 235, 'perfil' => 'llano', 'paves' => 0], // Bretagne Classic - Ouest-France
            ['num_carrera' => 65, 'num_etapa' => 1, 'nombre' => 'Solarino - Sortino', 'km' => 165, 'perfil' => 'media-montaña', 'paves' => 0], // Trofeo Pantalica
            ['num_carrera' => 67, 'num_etapa' => 1, 'nombre' => 'Québec - Québec', 'km' => 203, 'perfil' => 'media-montaña', 'paves' => 0], // Grand Prix Cycliste de Québec
            ['num_carrera' => 68, 'num_etapa' => 1, 'nombre' => 'Castrocaro Terme e Terra del Sole - Cesenatico', 'km' => 200, 'perfil' => 'media-montaña', 'paves' => 0], // Memorial Marco Pantani
            ['num_carrera' => 69, 'num_etapa' => 1, 'nombre' => 'Montréal - Montréal', 'km' => 205, 'perfil' => 'media-montaña', 'paves' => 0], // Grand Prix Cycliste de Montréal
            ['num_carrera' => 72, 'num_etapa' => 1, 'nombre' => 'Bologna - San Luca', 'km' => 192, 'perfil' => 'media-montaña', 'paves' => 0], // Giro dell'Emilia
            ['num_carrera' => 73, 'num_etapa' => 1, 'nombre' => 'Bergamo - Lecco', 'km' => 247, 'perfil' => 'media-montaña', 'paves' => 0], // Il Lombardia
            ['num_carrera' => 74, 'num_etapa' => 1, 'nombre' => 'Kayseri - Erciyes Ski Center', 'km' => 132, 'perfil' => 'montaña', 'paves' => 0], // Grand Prix Kaisareia
            ['num_carrera' => 76, 'num_etapa' => 1, 'nombre' => 'Cittadella - Padova', 'km' => 192, 'perfil' => 'media-montaña', 'paves' => 0], // Giro del Veneto
            ['num_carrera' => 77, 'num_etapa' => 1, 'nombre' => 'Les Herbiers - Les Herbiers', 'km' => 49, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0], // Chrono des Nations

            // VUELTAS
            ['num_carrera' => 1, 'num_etapa' => 1, 'nombre' => 'Nuriootpa - Angaston', 'km' => 136, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 1, 'num_etapa' => 2, 'nombre' => 'Prospect - Stirling', 'km' => 150, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 1, 'num_etapa' => 3, 'nombre' => 'Norwood - Campbelltown', 'km' => 143, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 1, 'num_etapa' => 4, 'nombre' => 'Unley - Victor Harbor', 'km' => 149, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 1, 'num_etapa' => 5, 'nombre' => 'McLaren Vale - Old Willunga Hill', 'km' => 151, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 1, 'num_etapa' => 6, 'nombre' => 'Adelaide - Adelaide', 'km' => 83, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 2, 'num_etapa' => 1, 'nombre' => 'San Luis - Villa Mercedes', 'km' => 189, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 2, 'num_etapa' => 2, 'nombre' => 'La Punta - Mirador de Potrero', 'km' => 186, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 2, 'num_etapa' => 3, 'nombre' => 'Concarán - Juana Koslay', 'km' => 185, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 2, 'num_etapa' => 4, 'nombre' => 'Villa Dolores - Alto del Amago', 'km' => 148, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 2, 'num_etapa' => 5, 'nombre' => 'San Luis - San Luis', 'km' => 17, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 2, 'num_etapa' => 6, 'nombre' => 'Achiras - Filo Sierras Comechingones', 'km' => 121, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 2, 'num_etapa' => 7, 'nombre' => 'San Luis - San Luis', 'km' => 125, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 5, 'num_etapa' => 1, 'nombre' => 'Al Mamzar Corniche', 'km' => 8.9,  'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 5, 'num_etapa' => 2, 'nombre' => 'University City - Al Badayer Oasis Retreat', 'km' => 130, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 5, 'num_etapa' => 3, 'nombre' => 'Dibba Al Hisn - Wadi Al Rabka Dam', 'km' => 121, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 5, 'num_etapa' => 4, 'nombre' => 'Al Fujayrah - Khawr Fakkan', 'km' => 110, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 5, 'num_etapa' => 5, 'nombre' => 'Sharjah Safai Al Dhaid - Al Noor Mosque Sharjah', 'km' => 72, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 6, 'num_etapa' => 1, 'nombre' => 'Paipa - Duitama', 'km' => 151, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 6, 'num_etapa' => 2, 'nombre' => 'Paipa - Santa Rosa de Viterbo', 'km' => 172, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 6, 'num_etapa' => 3, 'nombre' => 'Tunja - Tunja', 'km' => 144, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 6, 'num_etapa' => 4, 'nombre' => 'Paipa - Zipaquira', 'km' => 178, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 6, 'num_etapa' => 5, 'nombre' => 'Cota - Alto del Vino', 'km' => 138, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 6, 'num_etapa' => 6, 'nombre' => 'Sopo - Bogota', 'km' => 138, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 8, 'num_etapa' => 1, 'nombre' => 'Al Hudayriat Island', 'km' => 16,   'perfil' => 'llano', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 8, 'num_etapa' => 2, 'nombre' => 'Yas Island - Abu Dhabi', 'km' => 183, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 8, 'num_etapa' => 3, 'nombre' => 'Al Ain - Jebel Hafeet', 'km' => 196, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 8, 'num_etapa' => 4, 'nombre' => 'Dubai - Hatta Dam', 'km' => 194, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 8, 'num_etapa' => 5, 'nombre' => 'Sharjah - Khor Fakkan', 'km' => 178, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 8, 'num_etapa' => 6, 'nombre' => 'Ajman - Jebel Jais', 'km' => 147, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 8, 'num_etapa' => 7, 'nombre' => 'Dubai - Dubai', 'km' => 121, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 9, 'num_etapa' => 1, 'nombre' => 'O Porriño - Vigo', 'km' => 163, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 9, 'num_etapa' => 2, 'nombre' => 'Coruña - Coruña', 'km' => 14, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 9, 'num_etapa' => 3, 'nombre' => 'Taboada - Chantada', 'km' => 145, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 9, 'num_etapa' => 4, 'nombre' => 'Maceda - Luintra', 'km' => 146, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 10, 'num_etapa' => 1, 'nombre' => 'Kresten Royal Hotel Area - Koskinou', 'km' => 171, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 10, 'num_etapa' => 2, 'nombre' => 'Rhodes - Salakos', 'km' => 166, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 13, 'num_etapa' => 1, 'nombre' => 'Mantes-la-Jolie - Mantes-la-Jolie', 'km' => 160, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 2, 'nombre' => 'Rambouillet - Saint-Georges-sur-Baulche', 'km' => 204, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 3, 'nombre' => 'Toucy - Circuit de Nevers Magny-Cours', 'km' => 177, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 4, 'nombre' => 'Nevers - Belleville', 'km' => 195, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 5, 'nombre' => 'Crêches-sur-Saône - Rive-de-Gier', 'km' => 147, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 6, 'nombre' => 'Saint-Saturnin-lès-Avignon - Fayence', 'km' => 218, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 7, 'nombre' => 'Mougins - Biot Sophia Antipolis', 'km' => 192, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 13, 'num_etapa' => 8, 'nombre' => 'Nice - Nice', 'km' => 128, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 15, 'num_etapa' => 1, 'nombre' => 'Donoratico - San Vincenzo', 'km' => 17, 'perfil' => 'llano', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 15, 'num_etapa' => 2, 'nombre' => 'San Vincenzo - Cascina', 'km' => 168, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 15, 'num_etapa' => 3, 'nombre' => 'Cascina - Arezzo', 'km' => 199, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 15, 'num_etapa' => 4, 'nombre' => 'Indicatore (Arezzo) - Cittareale', 'km' => 244, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 15, 'num_etapa' => 5, 'nombre' => 'Amatrice - Guardiagrele', 'km' => 192, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 15, 'num_etapa' => 6, 'nombre' => 'Bucchianico - Porto Sant\'Elpidio', 'km' => 185, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 15, 'num_etapa' => 7, 'nombre' => 'San Benedetto del Tronto - San Benedetto del Tronto', 'km' => 10, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],

            ['num_carrera' => 16, 'num_etapa' => 1, 'nombre' => 'Bruxelles - Bruxelles', 'km' => 190, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 4],
            ['num_carrera' => 16, 'num_etapa' => 2, 'nombre' => 'Riemst - Aywalle', 'km' => 153, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 16, 'num_etapa' => 3, 'nombre' => 'Essen - Geraardsbergen', 'km' => 189, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 4],
            ['num_carrera' => 16, 'num_etapa' => 4, 'nombre' => 'koksijde - De Panne', 'km' =>   7, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],

            ['num_carrera' => 17, 'num_etapa' => 1, 'nombre' => 'Jurgow - Bukovina Resort', 'km' => 26, 'perfil' => 'media-montaña', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 17, 'num_etapa' => 2, 'nombre' => 'Bukovina Resort - Bukovina Tatrzanska', 'km' => 113, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 20, 'num_etapa' => 1, 'nombre' => 'Calella - Calella', 'km' => 162, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 20, 'num_etapa' => 2, 'nombre' => 'Banyoles - Banyoles', 'km' => 21,  'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 20, 'num_etapa' => 3, 'nombre' => 'Canal Olimpic de Catalunya - Vallter 2000', 'km' => 192, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 20, 'num_etapa' => 4, 'nombre' => 'Ripoll - Port Aine', 'km' => 164, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 20, 'num_etapa' => 5, 'nombre' => 'La Pobla de Segur - Manresa', 'km' => 196, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 20, 'num_etapa' => 6, 'nombre' => 'Tarragona - Mataro', 'km' => 180, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 20, 'num_etapa' => 7, 'nombre' => 'Barcelona - Barcelona', 'km' => 121, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 22, 'num_etapa' => 1, 'nombre' => 'Gatteo - Gatteo', 'km' => 93,  'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 22, 'num_etapa' => 2, 'nombre' => 'Gatteo - Gatteo', 'km' => 13,  'perfil' => 'llano', 'tipo' => 'cre',    'paves' => 0],
            ['num_carrera' => 22, 'num_etapa' => 3, 'nombre' => 'Riccione - Sogliano al Rubicone', 'km' => 158, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 22, 'num_etapa' => 4, 'nombre' => 'Riccione - Riccione', 'km' => 159, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 22, 'num_etapa' => 5, 'nombre' => 'San Marino - San Marino', 'km' => 151, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 22, 'num_etapa' => 6, 'nombre' => 'Fiorano Modenese - Montegibbio', 'km' => 12,  'perfil' => 'media-montaña', 'tipo' => 'cri', 'paves' => 0],

            ['num_carrera' => 28, 'num_etapa' => 1, 'nombre' => 'Ordizia - Ordizia', 'km' => 150, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 28, 'num_etapa' => 2, 'nombre' => 'Ordizia - Dantxarinea (Urdazubi)', 'km' => 157, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 28, 'num_etapa' => 3, 'nombre' => 'Urdazubi-Urdax - Vitoria-Gasteiz', 'km' => 198, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 28, 'num_etapa' => 4, 'nombre' => 'Vitoria-Gasteiz - Arrate (Eibar)', 'km' => 150, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 28, 'num_etapa' => 5, 'nombre' => 'Eibar - Markina-Xemein', 'km' => 156, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 28, 'num_etapa' => 6, 'nombre' => 'Markina-Xemein', 'km' => 22, 'perfil' => 'media-montaña', 'tipo' => 'cri', 'paves' => 0],

            ['num_carrera' => 30, 'num_etapa' => 1, 'nombre' => 'Catania - Milazzo', 'km' => 160, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 30, 'num_etapa' => 2, 'nombre' => 'Capo d\'Orlando - Palermo', 'km' => 231, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 30, 'num_etapa' => 3, 'nombre' => 'Caltanisetta - Ragusa', 'km' => 183, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 30, 'num_etapa' => 4, 'nombre' => 'Giardini Naxos - Etna (Nicolosi)', 'km' => 129, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 34, 'num_etapa' => 1, 'nombre' => 'Ascona - Ascona', 'km' => 4.7, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 34, 'num_etapa' => 2, 'nombre' => 'Ascona - Sion', 'km' => 202, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 34, 'num_etapa' => 3, 'nombre' => 'Sion - Montreux', 'km' => 167, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 34, 'num_etapa' => 4, 'nombre' => 'Le Bouveret - Aigle', 'km' => 175, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 34, 'num_etapa' => 5, 'nombre' => 'Fribourg - Fribourg', 'km' => 175, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 34, 'num_etapa' => 6, 'nombre' => 'Neuchâtel - Neuchâtel', 'km' => 18, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],

            ['num_carrera' => 39, 'num_etapa' => 1, 'nombre' => 'Long Beach - Long Beach', 'km' => 136, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 39, 'num_etapa' => 2, 'nombre' => 'Ventura - Gilbratar Road', 'km' => 159, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 39, 'num_etapa' => 3, 'nombre' => 'King City - Laguna Seca', 'km' => 195, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 39, 'num_etapa' => 4, 'nombre' => 'San José - Morgan Hill', 'km' => 34, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 39, 'num_etapa' => 5, 'nombre' => 'Stockton - Elk Grove', 'km' => 174, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 39, 'num_etapa' => 6, 'nombre' => 'Folsom - South Lake Tahoe', 'km' => 196, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 39, 'num_etapa' => 7, 'nombre' => 'Sacramento - Sacramento', 'km' => 168, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 41, 'num_etapa' => 1, 'nombre' => 'Stavanger - Egersund', 'km' => 167, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 41, 'num_etapa' => 2, 'nombre' => 'Kvinesdal - Mandal', 'km' => 169, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 41, 'num_etapa' => 3, 'nombre' => 'Lyngdal - Kristiansand', 'km' => 184, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 41, 'num_etapa' => 4, 'nombre' => 'Arendal - Sandefjord', 'km' => 220, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 43, 'num_etapa' => 1, 'nombre' => 'Lyon - Lyon', 'km' => 10.0, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 2, 'nombre' => 'Tarare - Pays d\'Olliergues-Col du Béal', 'km' => 154, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 3, 'nombre' => 'Ambert - Le Teil', 'km' => 194, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 4, 'nombre' => 'Montélimar - Gap', 'km' => 168, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 5, 'nombre' => 'Sisteron - La Mure', 'km' => 181, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 6, 'nombre' => 'Grenoble - Poisy', 'km' => 167, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 7, 'nombre' => 'Ville-la-Grand - Finhaut-Emosson', 'km' => 159, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 43, 'num_etapa' => 8, 'nombre' => 'Megève - Courchevel', 'km' => 128, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 46, 'num_etapa' => 1, 'nombre' => 'Bellinzona - Bellinzona', 'km' => 9.3, 'perfil' => 'media-montaña', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 2, 'nombre' => 'Bellinzona - Sarnen', 'km' => 182, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 3, 'nombre' => 'Sarnen - Heiden', 'km' => 202, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 4, 'nombre' => 'Heiden - Ossingen', 'km' => 158, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 5, 'nombre' => 'Ossingen - Büren an der Aare', 'km' => 181, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 6, 'nombre' => 'Büren an der Aare - Delémont', 'km' => 180, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 7, 'nombre' => 'Worb - Worb', 'km' => 24, 'perfil' => 'media-montaña', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 46, 'num_etapa' => 8, 'nombre' => 'Delémont - Verbier', 'km' => 215, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 48, 'num_etapa' => 1, 'nombre' => 'Umag - Umag', 'km' => 2.9, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 48, 'num_etapa' => 2, 'nombre' => 'Porec - Labin', 'km' => 157, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 48, 'num_etapa' => 3, 'nombre' => 'Vrsar - Motovun', 'km' => 164, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 48, 'num_etapa' => 4, 'nombre' => 'Pazin - Umag', 'km' => 139, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 53, 'num_etapa' => 1, 'nombre' => 'La Louvière - Les Bons Villers', 'km' => 182, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 53, 'num_etapa' => 2, 'nombre' => 'Villers-La-Ville - Namur', 'km' => 159, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 1],
            ['num_carrera' => 53, 'num_etapa' => 3, 'nombre' => 'Chrono des Arenberg', 'km' => 48, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 53, 'num_etapa' => 4, 'nombre' => 'Huy - Waremme', 'km' => 181, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 53, 'num_etapa' => 5, 'nombre' => 'Harelbeke - Oude Kwaremont', 'km' => 169, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 3],

            ['num_carrera' => 56, 'num_etapa' => 1, 'nombre' => 'Gdansk - Bydgoszcz', 'km' => 223, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 56, 'num_etapa' => 2, 'nombre' => 'Torun - Warszawa', 'km' => 232, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 56, 'num_etapa' => 3, 'nombre' => 'Kielce - Rzeszów', 'km' => 180, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 56, 'num_etapa' => 4, 'nombre' => 'Tarnów - Katowice', 'km' => 231, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 56, 'num_etapa' => 5, 'nombre' => 'Zakopane - Strbske Pleso', 'km' => 178, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 56, 'num_etapa' => 6, 'nombre' => 'Bukovina Terma Hotel Spa - Bukowina Tatrzanska', 'km' => 176, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 56, 'num_etapa' => 7, 'nombre' => 'Kraków - Kraków', 'km' => 24, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],

            ['num_carrera' => 58, 'num_etapa' => 1, 'nombre' => 'Montréal-La-Cluse - Ceyzériat', 'km' => 134, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 58, 'num_etapa' => 2, 'nombre' => 'Lagnieu - Lelex Mont Jura', 'km' => 149, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 58, 'num_etapa' => 3, 'nombre' => 'Saint-Vulbas - Grand Colombier', 'km' => 140, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 62, 'num_etapa' => 1, 'nombre' => 'Waalwijk - Middelburg', 'km' => 198, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 62, 'num_etapa' => 2, 'nombre' => 'Sittard - Sittard', 'km' => 18,  'perfil' => 'llano', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 62, 'num_etapa' => 3, 'nombre' => 'Riems - Genk', 'km' => 184, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 62, 'num_etapa' => 4, 'nombre' => 'Heers - Bergen op Zoom', 'km' => 213, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 62, 'num_etapa' => 5, 'nombre' => 'Maldegem - Geraardsbergen', 'km' => 202, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 2],

            ['num_carrera' => 66, 'num_etapa' => 1, 'nombre' => 'Polkowice - Polkowice', 'km' => 16, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 66, 'num_etapa' => 2, 'nombre' => 'Chojnów – Zlotoryja', 'km' => 187, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 66, 'num_etapa' => 3, 'nombre' => 'Glogów – Polkowice', 'km' => 116, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 70, 'num_etapa' => 1, 'nombre' => 'Krnov - Krnov', 'km' => 1.9, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 70, 'num_etapa' => 2, 'nombre' => 'Jesenik - Rymarov', 'km' => 133, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 70, 'num_etapa' => 3, 'nombre' => 'Krnov - Dlouhe Strane', 'km' => 150, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 70, 'num_etapa' => 4, 'nombre' => 'Jasenik - Jasenik Hotel Priessnitz', 'km' => 158, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],

            ['num_carrera' => 71, 'num_etapa' => 1, 'nombre' => 'Osijek - Varazdin', 'km' => 240, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 71, 'num_etapa' => 2, 'nombre' => 'Plitvice - Split', 'km' => 240, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 71, 'num_etapa' => 3, 'nombre' => 'Makarska - Sibernik', 'km' => 179, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 71, 'num_etapa' => 4, 'nombre' => 'Porec - Umag', 'km' => 39, 'perfil' => 'llano', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 71, 'num_etapa' => 5, 'nombre' => 'Crikvenica - Ucka', 'km' => 113, 'perfil' => 'montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 71, 'num_etapa' => 6, 'nombre' => 'Samobor - Zagreb', 'km' => 153, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 2],

            ['num_carrera' => 75, 'num_etapa' => 1, 'nombre' => 'Beihai - Beihai', 'km' => 107, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 75, 'num_etapa' => 2, 'nombre' => 'Qinzhou - Nanning', 'km' => 156, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 75, 'num_etapa' => 3, 'nombre' => 'Nanning - Nanning', 'km' => 125, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 75, 'num_etapa' => 4, 'nombre' => 'Nanning - Mashan Nongla Scenic Spot', 'km' => 151, 'perfil' => 'media-montaña', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 75, 'num_etapa' => 5, 'nombre' => 'Liuzhou - Guilin', 'km' => 212, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],
            ['num_carrera' => 75, 'num_etapa' => 6, 'nombre' => 'Guilin - Guilin', 'km' => 168, 'perfil' => 'llano', 'tipo' => 'normal', 'paves' => 0],

            // Grandes Vueltas
            // Giro
            ['num_carrera' => 38, 'num_etapa' => 1, 'nombre' => 'Belfast - Belfast', 'km' => 21, 'perfil' => 'llano', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 2, 'nombre' => 'Belfast - Belfast', 'km' => 216, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 3, 'nombre' => 'Armagh - Dublin', 'km' => 186, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 4, 'nombre' => 'Giovinazzo - Bari', 'km' => 122, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 5, 'nombre' => 'Taranto - Viggiano', 'km' => 203, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 6, 'nombre' => 'Sassano - Montecassino', 'km' => 248, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 7, 'nombre' => 'Frosinone - Foligno', 'km' => 211, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 8, 'nombre' => 'Foligno - Montecopiolo', 'km' => 172, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 9, 'nombre' => 'Lugo - Sestola', 'km' => 168, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 10, 'nombre' => 'Modena - Salsomaggiore Terme', 'km' => 182, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 11, 'nombre' => 'Collecchio - Savona', 'km' => 248, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 12, 'nombre' => 'Barbaresco - Barolo', 'km' => 42, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 13, 'nombre' => 'Fossano - Rivarolo Canavese', 'km' => 154, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 14, 'nombre' => 'Aglìe - Oropa', 'km' => 158, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 15, 'nombre' => 'Valdengo - Plan di Montecampione', 'km' => 213, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 16, 'nombre' => 'Ponte di Legno - Val Martello', 'km' => 138, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 17, 'nombre' => 'Sarnonico - Vittorio Veneto', 'km' => 208, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 18, 'nombre' => 'Belluno - Rifugio Panarotta (Valsugana)', 'km' => 168, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 19, 'nombre' => 'Bassano Del Grappa - Cima Grappa', 'km' => 26, 'perfil' => 'montaña', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 20, 'nombre' => 'Maniago - Monte Zoncolan', 'km' => 164, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 38, 'num_etapa' => 21, 'nombre' => 'Gemona - Trieste', 'km' => 168, 'perfil' => 'llano', 'paves' => 0],

            // Tour
            ['num_carrera' => 50, 'num_etapa' => 1, 'nombre' => 'Leeds - Harrogate', 'km' => 192, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 2, 'nombre' => 'York - Sheffield', 'km' => 199, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 3, 'nombre' => 'Cambridge - Londres', 'km' => 157, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 4, 'nombre' => 'Le Touquet-Paris-Plage - Lille Métropole', 'km' => 162, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 5, 'nombre' => 'Ypres - Arenberg Porte du Hainaut', 'km' => 153, 'perfil' => 'llano', 'paves' => 3],
            ['num_carrera' => 50, 'num_etapa' => 6, 'nombre' => 'Arras - Reims', 'km' => 191, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 7, 'nombre' => 'Epernay - Nancy', 'km' => 231, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 8, 'nombre' => 'Tomblaine - Gérardmer la Mauselaine', 'km' => 161, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 9, 'nombre' => 'Gérardmer - Mulhouse', 'km' => 164, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 10, 'nombre' => 'Mulhouse - La Planche des Belles Filles', 'km' => 162, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 11, 'nombre' => 'Besançon - Oyonnax', 'km' => 182, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 12, 'nombre' => 'Bourg en Bresse - Saint Etienne', 'km' => 184, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 13, 'nombre' => 'Saint Etienne - Chamrousse', 'km' => 199, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 14, 'nombre' => 'Grenoble - Risoul', 'km' => 173, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 15, 'nombre' => 'Tallard - Nîmes', 'km' => 213, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 16, 'nombre' => 'Carcassonne - Bagnères de Luchon', 'km' => 232, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 17, 'nombre' => 'Saint Gaudens - Saint Lary Soulan Pla d\'Adet', 'km' => 124, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 18, 'nombre' => 'Pau - Hautacam', 'km' => 146, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 19, 'nombre' => 'Maubourguet Pays du Val d\'Adour - Bergerac', 'km' => 207, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 20, 'nombre' => 'Bergerac - Périgueux', 'km' => 52, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 50, 'num_etapa' => 21, 'nombre' => 'Versailles - Paris Champs Elysées', 'km' => 126, 'perfil' => 'llano', 'paves' => 0],

            // Vuelta
            ['num_carrera' => 63, 'num_etapa' => 1, 'nombre' => 'Jerez de la Frontera - Jerez de la Frontera', 'km' => 12, 'perfil' => 'llano', 'tipo' => 'cre', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 2, 'nombre' => 'Algeciras - San Fernando', 'km' => 169, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 3, 'nombre' => 'Cádiz - Arcos de la Frontera', 'km' => 185, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 4, 'nombre' => 'Mairena del Alcor - Córdoba', 'km' => 171, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 5, 'nombre' => 'Priego de Córdoba - Ronda', 'km' => 176, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 6, 'nombre' => 'Benalmádena - La Zubia', 'km' => 156, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 7, 'nombre' => 'Alhendín - Alcaudete', 'km' => 166, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 8, 'nombre' => 'Baeza - Albacete', 'km' => 206, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 9, 'nombre' => 'Carboneras de Guadazaón - Aramón Valdelinares', 'km' => 183, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 10, 'nombre' => 'Monasterio de Veruela - Borja', 'km' => 34, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 11, 'nombre' => 'Pamplona - Santuario de San Miguel de Aralar', 'km' => 150, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 12, 'nombre' => 'Logroño - Logroño', 'km' => 167, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 13, 'nombre' => 'Belorado - Obregón. Parque de Cabárceno', 'km' => 179, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 14, 'nombre' => 'Santander - La Camperona. Valle de Sábero', 'km' => 196, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 15, 'nombre' => 'Oviedo - Lagos de Covadonga', 'km' => 148, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 16, 'nombre' => 'San Martín del Rey Aurelio - La Farrapona. Lago de Somiedo', 'km' => 158, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 17, 'nombre' => 'Ortigueira - Coruña', 'km' => 171, 'perfil' => 'llano', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 18, 'nombre' => 'A Estrada - Mont Castrove. Meis', 'km' => 167, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 19, 'nombre' => 'Salvaterra do Miño - Cangas do Morrazo', 'km' => 173, 'perfil' => 'media-montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 20, 'nombre' => 'Santo Estevo de Ribas de Sil - Puerto de Ancares', 'km' => 162, 'perfil' => 'montaña', 'paves' => 0],
            ['num_carrera' => 63, 'num_etapa' => 21, 'nombre' => 'Santiago de Compostela - Santiago de Compostela', 'km' => 10, 'perfil' => 'llano', 'tipo' => 'cri', 'paves' => 0],

        ];

        foreach ($etapas as $etapa) {
            // Buscar la etapa existente y actualizarla
            Etapa::where('num_carrera', $etapa['num_carrera'])
                ->where('num_etapa', $etapa['num_etapa'])
                ->where('temporada', 5)
                ->update([
                    'nombre' => $etapa['nombre'],
                    'km' => $etapa['km'],
                    'perfil' => $etapa['perfil'],
                    'tipo' => $etapa['tipo'] ?? 'normal',
                    'paves' => $etapa['paves'] ?? 0,
                    'imagen' => null,
                ]);
        }
    }
}
