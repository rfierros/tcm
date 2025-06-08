<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritosEtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favoritos = [
            ['temporada' => 5, 'num_carrera' => 5, 'num_etapa' => 1, 'fav1' => 10946, 'fav2' => 11806, 'fav3' => 12011, 'fav4' => 12448, 'fav5' => 11875, 'fav6' => 7570, 'fav7' => 12819, 'fav8' => 6677, 'fav9' => 13302, 'fav10' => 14323, 'fav11' => 13393, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 5, 'num_etapa' => 2, 'fav1' => 11689, 'fav2' => 12774, 'fav3' => 12615, 'fav4' => 3109, 'fav5' => 14327, 'fav6' => 12819, 'fav7' => 7146, 'fav8' => 12743, 'fav9' => 13624, 'fav10' => 11753, 'fav11' => 14190, 'created_at' => now(), 'updated_at' => now()],
            // ['temporada' => 5, 'num_carrera' => 5, 'num_etapa' => 3, 'fav1' => ww, 'fav2' => ww, 'fav3' => ww, 'fav4' => ww, 'fav5' => ww, 'fav6' => ww, 'fav7' => ww, 'fav8' => ww, 'fav9' => ww, 'fav10' => ww, 'fav11' => ww, 'created_at' => now(), 'updated_at' => now()],
            // ['temporada' => 5, 'num_carrera' => 5, 'num_etapa' => 4, 'fav1' => ww, 'fav2' => ww, 'fav3' => ww, 'fav4' => ww, 'fav5' => ww, 'fav6' => ww, 'fav7' => ww, 'fav8' => ww, 'fav9' => ww, 'fav10' => ww, 'fav11' => ww, 'created_at' => now(), 'updated_at' => now()],
            // ['temporada' => 5, 'num_carrera' => 5, 'num_etapa' => 5, 'fav1' => ww, 'fav2' => ww, 'fav3' => ww, 'fav4' => ww, 'fav5' => ww, 'fav6' => ww, 'fav7' => ww, 'fav8' => ww, 'fav9' => ww, 'fav10' => ww, 'fav11' => ww, 'created_at' => now(), 'updated_at' => now()],
            // 08.aue tour
            // ['temporada' => 5, 'num_carrera' => 14, 'num_etapa' => 1, 'fav1' => ww, 'fav2' => ww, 'fav3' => ww, 'fav4' => ww, 'fav5' => ww, 'fav6' => ww, 'fav7' => ww, 'fav8' => ww, 'fav9' => ww, 'fav10' => ww, 'fav11' => ww, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 8, 'num_etapa' => 2, 'fav1' => 2544, 'fav2' => 3387, 'fav3' => 2626, 'fav4' => 6300, 'fav5' => 2452, 'fav6' => 2327, 'fav7' => 5978, 'fav8' => 1939, 'fav9' => 3564, 'fav10' => 1947, 'fav11' => 6874, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 8, 'num_etapa' => 3, 'fav1' => 3365, 'fav2' => 3367, 'fav3' => 3280, 'fav4' => 2543, 'fav5' => 6777, 'fav6' => 566, 'fav7' => 5672, 'fav8' => 1922, 'fav9' => 6088, 'fav10' => 6195, 'fav11' => 5962, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 8, 'num_etapa' => 4, 'fav1' => 3365, 'fav2' => 3367, 'fav3' => 1981, 'fav4' => 5502, 'fav5' => 5978, 'fav6' => 6764, 'fav7' => 3280, 'fav8' => 5962, 'fav9' => 3044, 'fav10' => 3257, 'fav11' => 6501, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 8, 'num_etapa' => 5, 'fav1' => 2544, 'fav2' => 3387, 'fav3' => 2452, 'fav4' => 2626, 'fav5' => 2327, 'fav6' => 1939, 'fav7' => 6300, 'fav8' => 5978, 'fav9' => 1947, 'fav10' => 3564, 'fav11' => 6313, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 8, 'num_etapa' => 6, 'fav1' => 6195, 'fav2' => 5672, 'fav3' => 6777, 'fav4' => 3280, 'fav5' => 6327, 'fav6' => 2046, 'fav7' => 566, 'fav8' => 3700, 'fav9' => 7489, 'fav10' => 3915, 'fav11' => null, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 8, 'num_etapa' => 7, 'fav1' => 3387, 'fav2' => 2544, 'fav3' => 2452, 'fav4' => 2626, 'fav5' => 2327, 'fav6' => 6300, 'fav7' => 3564, 'fav8' => 1939, 'fav9' => 5978, 'fav10' => 1947, 'fav11' => 6874, 'created_at' => now(), 'updated_at' => now()],
            // 09.o camiño
            ['temporada' => 5, 'num_carrera' => 9, 'num_etapa' => 1, 'fav1' => 6913, 'fav2' => 7047, 'fav3' => 5106, 'fav4' => 5637, 'fav5' => 13861, 'fav6' => 5979, 'fav7' => 3617, 'fav8' => 178, 'fav9' => 3902, 'fav10' => 1948, 'fav11' => 6320, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 9, 'num_etapa' => 2, 'fav1' => 6609, 'fav2' => 5852, 'fav3' => 3945, 'fav4' => 14246, 'fav5' => 10946, 'fav6' => 6872, 'fav7' => 7065, 'fav8' => 3382, 'fav9' => 11806, 'fav10' => 5504, 'fav11' => 3932, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 9, 'num_etapa' => 3, 'fav1' => 13165, 'fav2' => 6001, 'fav3' => 5106, 'fav4' => 6913, 'fav5' => 14264, 'fav6' => 7308, 'fav7' => 5986, 'fav8' => 6766, 'fav9' => 7033, 'fav10' => 5984, 'fav11' => 3803, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 9, 'num_etapa' => 4, 'fav1' => 11390, 'fav2' => 6811, 'fav3' => 986, 'fav4' => 2523, 'fav5' => 14321, 'fav6' => 3372, 'fav7' => 14249, 'fav8' => 797, 'fav9' => 5633, 'fav10' => 2346, 'fav11' => 5793, 'created_at' => now(), 'updated_at' => now()],
            // 10. visit south islands
            ['temporada' => 5, 'num_carrera' => 10, 'num_etapa' => 1, 'fav1' => 11390, 'fav2' => 5304, 'fav3' => 1992, 'fav4' => 13165, 'fav5' => 7033, 'fav6' => 5986, 'fav7' => 10571, 'fav8' => 3363, 'fav9' => 11331, 'fav10' => 6994, 'fav11' => 6001, 'created_at' => now(), 'updated_at' => now()],
            ['temporada' => 5, 'num_carrera' => 10, 'num_etapa' => 2, 'fav1' => 13165, 'fav2' => 5106, 'fav3' => 6913, 'fav4' => 14264, 'fav5' => 6001, 'fav6' => 6766, 'fav7' => 7308, 'fav8' => 7033, 'fav9' => 5986, 'fav10' => 3698, 'fav11' => null, 'created_at' => now(), 'updated_at' => now()],

            // 11.omloop
            ['temporada' => 5, 'num_carrera' => 11, 'num_etapa' => 1, 'fav1' => 5978, 'fav2' => 1947, 'fav3' => 1939, 'fav4' => 6764, 'fav5' => 3404, 'fav6' => 3779, 'fav7' => 3388, 'fav8' => 2683, 'fav9' => 3564, 'fav10' => 3362, 'fav11' => null, 'created_at' => now(), 'updated_at' => now()],
            // Template
            // ['temporada' => 5, 'num_carrera' => 14, 'num_etapa' => 1, 'fav1' => ww, 'fav2' => ww, 'fav3' => ww, 'fav4' => ww, 'fav5' => ww, 'fav6' => ww, 'fav7' => ww, 'fav8' => ww, 'fav9' => ww, 'fav10' => ww, 'fav11' => ww, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('favoritos_etapa')->insert($favoritos);
    }
}
