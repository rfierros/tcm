<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;

// Para hacer correr este seeder basta con:
// php artisan db:seed --class=CarreraSeeder
class CarreraSeeder extends Seeder
{
    public function run()
    {
    $carreras = [
        ['nombre' => 'New Zealand Cycle Classic', 'dia_inicio' => 8, 'num_etapas' => 5, 'categoria' => 'U24', 'tipo' => 'Vuelta'],
        ['nombre' => 'Down Under', 'dia_inicio' => 9, 'num_etapas' => 6, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Clàssica C. Valenciana', 'dia_inicio' => 14, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Cadel Evans', 'dia_inicio' => 15, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'GP Marseillaise', 'dia_inicio' => 15, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Etoile de Bessèges', 'dia_inicio' => 16, 'num_etapas' => 5, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Jaén Paraiso Interior', 'dia_inicio' => 21, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'UAE Tour', 'dia_inicio' => 22, 'num_etapas' => 7, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Tour des Alpes-Maritimes', 'dia_inicio' => 22, 'num_etapas' => 3, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Omloop Het Nieuwsblad', 'dia_inicio' => 28, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Strade Bianchi', 'dia_inicio' => 29, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Paris Niza', 'dia_inicio' => 30, 'num_etapas' => 8, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Tirreno-Adriatico', 'dia_inicio' => 31, 'num_etapas' => 7, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Tour de Taiwan', 'dia_inicio' => 38, 'num_etapas' => 5, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Tour of Rhodes', 'dia_inicio' => 38, 'num_etapas' => 3, 'categoria' => 'U24', 'tipo' => 'Vuelta'],
        ['nombre' => 'Bredene Koksijde Classic', 'dia_inicio' => 41, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Milano-Sanremo', 'dia_inicio' => 42, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Monumento'],
        ['nombre' => 'Volta a Cataluña', 'dia_inicio' => 43, 'num_etapas' => 7, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Brugge-De Panne', 'dia_inicio' => 43, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'E3', 'dia_inicio' => 46, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Gent-Wevelgem', 'dia_inicio' => 49, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Dwars door Vlaanderen', 'dia_inicio' => 50, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Paris-Camembert', 'dia_inicio' => 50, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour de Flandes', 'dia_inicio' => 51, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Monumento'],
        ['nombre' => 'Itzulia', 'dia_inicio' => 52, 'num_etapas' => 6, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'París-Roubaix', 'dia_inicio' => 58, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Monumento'],
        ['nombre' => 'Brabantse Pijl', 'dia_inicio' => 59, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour of the Alps', 'dia_inicio' => 59, 'num_etapas' => 5, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Amstel Gold Race', 'dia_inicio' => 60, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'La Fleche Wallonne', 'dia_inicio' => 70, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Liege-Bastogne-Liege', 'dia_inicio' => 64, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Monumento'],
        ['nombre' => 'Tour de Romandía', 'dia_inicio' => 65, 'num_etapas' => 6, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Vuelta Asturias', 'dia_inicio' => 65, 'num_etapas' => 3, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Eschborn-Frankfurt', 'dia_inicio' => 70, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Giro de Italia', 'dia_inicio' => 71, 'num_etapas' => 21, 'categoria' => 'WT', 'tipo' => 'GV'],
        ['nombre' => 'Sundvolden GP', 'dia_inicio' => 71, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour de Hongrie', 'dia_inicio' => 72, 'num_etapas' => 5, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Veenendaal-Veenendaal', 'dia_inicio' => 78, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Rund um Köln', 'dia_inicio' => 84, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Criterium du Dauphine', 'dia_inicio' => 92, 'num_etapas' => 8, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Brussels Cycling Classic', 'dia_inicio' => 93, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Classica da Arrabida', 'dia_inicio' => 95, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour de Suiza', 'dia_inicio' => 98, 'num_etapas' => 8, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Baloise Belgium Tour', 'dia_inicio' => 101, 'num_etapas' => 5, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Tour de Francia', 'dia_inicio' => 106, 'num_etapas' => 21, 'categoria' => 'WT', 'tipo' => 'GV'],
        ['nombre' => 'Districtenpijl', 'dia_inicio' => 109, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Giro Calabria', 'dia_inicio' => 112, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Ordiziako Klasika', 'dia_inicio' => 114, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Chrono des Nations U24', 'dia_inicio' => 119, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Vuelta a Burgos', 'dia_inicio' => 127, 'num_etapas' => 5, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'San Sebastian', 'dia_inicio' => 127, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour de Polonia', 'dia_inicio' => 128, 'num_etapas' => 7, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Vuelta a España', 'dia_inicio' => 134, 'num_etapas' => 21, 'categoria' => 'WT', 'tipo' => 'GV'],
        ['nombre' => 'Rutland-Melton', 'dia_inicio' => 135, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour Poitou', 'dia_inicio' => 136, 'num_etapas' => 4, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Bretagne Classic', 'dia_inicio' => 140, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour de Benelux', 'dia_inicio' => 141, 'num_etapas' => 7, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Bremer Cyclassics', 'dia_inicio' => 148, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'GP Quebec', 'dia_inicio' => 149, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'GP Montreal', 'dia_inicio' => 150, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour de Catamarca', 'dia_inicio' => 151, 'num_etapas' => 4, 'categoria' => 'U24', 'tipo' => 'Vuelta'],
        ['nombre' => 'Il Lombardia Under 24', 'dia_inicio' => 155, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Tour of Taihu Lake', 'dia_inicio' => 158, 'num_etapas' => 4, 'categoria' => 'Conti', 'tipo' => 'Vuelta'],
        ['nombre' => 'Il Lombardía', 'dia_inicio' => 160, 'num_etapas' => 1, 'categoria' => 'WT', 'tipo' => 'Monumento'],
        ['nombre' => 'Chrono des Nations', 'dia_inicio' => 161, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Gree Tour of Guanxi', 'dia_inicio' => 162, 'num_etapas' => 6, 'categoria' => 'WT', 'tipo' => 'Vuelta'],
        ['nombre' => 'Japan Cup', 'dia_inicio' => 163, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Skive', 'dia_inicio' => 166, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
        ['nombre' => 'Gran Piemonte', 'dia_inicio' => 168, 'num_etapas' => 1, 'categoria' => 'Conti', 'tipo' => 'Clasica'],
        ['nombre' => 'Grand Prix Erciyes', 'dia_inicio' => 168, 'num_etapas' => 1, 'categoria' => 'U24', 'tipo' => 'Clasica'],
    ];


        foreach ($carreras as $carrera) {
            Carrera::create(array_merge($carrera, ['temporada' => 4]));
        }
    }
}
