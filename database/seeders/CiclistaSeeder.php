<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CiclistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // registros de mi equipo
        $ciclistas = [
            [
                'temporada' => 4,
                'clave_id' => 6001,
                'apellido' => 'Vendrame',
                'nombre' => 'A.',
                'pais' => 'ITA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'ardenas',
                'edad' => 31,
                'lla' => 74.00,
                'mon' => 70.00,
                'col' => 76.00,
                'cri' => 64.00,
                'pro' => 67.00,
                'pav' => 72.00,
                'spr' => 73.00,
                'acc' => 75.00,
                'des' => 75.00,
                'com' => 76.00,
                'ene' => 75.00,
                'res' => 75.00,
                'rec' => 72.00,
                'media' => 75.40,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 12952,
                'apellido' => 'Gonzalez',
                'nombre' => 'Ab.',
                'pais' => 'PRC',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'ardenas',
                'edad' => 25,
                'lla' => 72.50,
                'mon' => 73.60,
                'col' => 79.00,
                'cri' => 66.60,
                'pro' => 68.40,
                'pav' => 64.40,
                'spr' => 64.50,
                'acc' => 74.00,
                'des' => 68.50,
                'com' => 76.60,
                'ene' => 72.60,
                'res' => 71.60,
                'rec' => 64.00,
                'media' => 75.33,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 3859,
                'apellido' => 'Pedersen',
                'nombre' => 'C.',
                'pais' => 'DEN',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'ardenas',
                'edad' => 29,
                'lla' => 74.73,
                'mon' => 64.30,
                'col' => 74.50,
                'cri' => 67.30,
                'pro' => 71.26,
                'pav' => 66.35,
                'spr' => 72.19,
                'acc' => 75.56,
                'des' => 69.28,
                'com' => 71.45,
                'ene' => 70.41,
                'res' => 72.90,
                'rec' => 70.36,
                'media' => 73.93,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14064,
                'apellido' => 'Lemmen',
                'nombre' => 'B.',
                'pais' => 'NED',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'ardenas',
                'edad' => 30,
                'lla' => 74.00,
                'mon' => 73.00,
                'col' => 74.00,
                'cri' => 69.00,
                'pro' => 70.00,
                'pav' => 66.00,
                'spr' => 67.00,
                'acc' => 73.00,
                'des' => 72.00,
                'com' => 73.00,
                'ene' => 74.00,
                'res' => 73.00,
                'rec' => 71.00,
                'media' => 73.80,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 11759,
                'apellido' => 'Craps',
                'nombre' => 'L.',
                'pais' => 'BEL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'ardenas',
                'edad' => 24,
                'lla' => 71.00,
                'mon' => 69.00,
                'col' => 72.00,
                'cri' => 65.00,
                'pro' => 64.00,
                'pav' => 71.00,
                'spr' => 69.00,
                'acc' => 72.00,
                'des' => 68.00,
                'com' => 67.00,
                'ene' => 72.00,
                'res' => 70.00,
                'rec' => 66.00,
                'media' => 71.80,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 7072,
                'apellido' => 'Hänninen',
                'nombre' => 'J.',
                'pais' => 'FIN',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'ardenas',
                'edad' => 28,
                'lla' => 64.98,
                'mon' => 71.80,
                'col' => 71.96,
                'cri' => 61.00,
                'pro' => 60.96,
                'pav' => 55.00,
                'spr' => 62.98,
                'acc' => 66.80,
                'des' => 71.88,
                'com' => 69.96,
                'ene' => 69.92,
                'res' => 67.88,
                'rec' => 62.92,
                'media' => 70.07,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14253,
                'apellido' => 'Vercher',
                'nombre' => 'M.',
                'pais' => 'FRA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'combatividad',
                'edad' => 24,
                'lla' => 73.00,
                'mon' => 66.00,
                'col' => 73.00,
                'cri' => 62.00,
                'pro' => 66.00,
                'pav' => 64.00,
                'spr' => 67.00,
                'acc' => 72.00,
                'des' => 70.00,
                'com' => 76.00,
                'ene' => 73.00,
                'res' => 73.00,
                'rec' => 64.00,
                'media' => 73.20,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 7190,
                'apellido' => 'Drizners',
                'nombre' => 'J.',
                'pais' => 'AUS',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'combatividad',
                'edad' => 26,
                'lla' => 72.50,
                'mon' => 62.30,
                'col' => 70.00,
                'cri' => 64.00,
                'pro' => 63.25,
                'pav' => 65.50,
                'spr' => 69.00,
                'acc' => 70.63,
                'des' => 69.50,
                'com' => 73.50,
                'ene' => 67.63,
                'res' => 66.63,
                'rec' => 63.63,
                'media' => 70.73,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14343,
                'apellido' => 'Okamika',
                'nombre' => 'A.',
                'pais' => 'ESP',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'combatividad',
                'edad' => 32,
                'lla' => 70.96,
                'mon' => 68.60,
                'col' => 71.90,
                'cri' => 59.00,
                'pro' => 57.90,
                'pav' => 61.00,
                'spr' => 62.96,
                'acc' => 65.60,
                'des' => 68.76,
                'com' => 76.90,
                'ene' => 66.84,
                'res' => 68.76,
                'rec' => 63.84,
                'media' => 70.07,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 3484,
                'apellido' => 'Mullen',
                'nombre' => 'R.',
                'pais' => 'IRL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'croner',
                'edad' => 31,
                'lla' => 70.00,
                'mon' => 60.00,
                'col' => 66.00,
                'cri' => 70.00,
                'pro' => 70.00,
                'pav' => 68.00,
                'spr' => 69.00,
                'acc' => 68.00,
                'des' => 69.00,
                'com' => 64.00,
                'ene' => 69.00,
                'res' => 68.00,
                'rec' => 68.00,
                'media' => 69.67,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 5675,
                'apellido' => 'Ciccone',
                'nombre' => 'G.',
                'pais' => 'ITA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'escalador',
                'edad' => 31,
                'lla' => 67.74,
                'mon' => 78.00,
                'col' => 74.89,
                'cri' => 65.20,
                'pro' => 62.54,
                'pav' => 66.89,
                'spr' => 66.00,
                'acc' => 76.06,
                'des' => 74.19,
                'com' => 82.02,
                'ene' => 75.30,
                'res' => 74.90,
                'rec' => 75.30,
                'media' => 76.73,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 6000,
                'apellido' => 'Sosa',
                'nombre' => 'I.',
                'pais' => 'COL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'escalador',
                'edad' => 28,
                'lla' => 62.64,
                'mon' => 79.90,
                'col' => 74.38,
                'cri' => 61.40,
                'pro' => 59.07,
                'pav' => 64.23,
                'spr' => 64.06,
                'acc' => 74.18,
                'des' => 68.94,
                'com' => 66.38,
                'ene' => 71.62,
                'res' => 72.28,
                'rec' => 63.62,
                'media' => 75.20,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14338,
                'apellido' => 'Thompson',
                'nombre' => 'R.',
                'pais' => 'NZL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'escalador',
                'edad' => 24,
                'lla' => 67.67,
                'mon' => 78.70,
                'col' => 70.68,
                'cri' => 63.70,
                'pro' => 62.68,
                'pav' => 60.00,
                'spr' => 62.67,
                'acc' => 74.70,
                'des' => 70.02,
                'com' => 73.68,
                'ene' => 70.68,
                'res' => 72.02,
                'rec' => 67.68,
                'media' => 74.33,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14278,
                'apellido' => 'Gloag',
                'nombre' => 'T.',
                'pais' => 'GBR',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'escalador',
                'edad' => 24,
                'lla' => 67.75,
                'mon' => 79.50,
                'col' => 70.88,
                'cri' => 61.80,
                'pro' => 61.88,
                'pav' => 62.00,
                'spr' => 64.75,
                'acc' => 73.50,
                'des' => 69.50,
                'com' => 65.88,
                'ene' => 70.00,
                'res' => 70.50,
                'rec' => 68.00,
                'media' => 73.80,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 3662,
                'apellido' => 'Figueiredo',
                'nombre' => 'F.',
                'pais' => 'POR',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'escalador',
                'edad' => 34,
                'lla' => 66.05,
                'mon' => 75.50,
                'col' => 72.83,
                'cri' => 65.10,
                'pro' => 64.83,
                'pav' => 56.51,
                'spr' => 61.25,
                'acc' => 72.50,
                'des' => 70.01,
                'com' => 71.43,
                'ene' => 64.80,
                'res' => 70.01,
                'rec' => 69.80,
                'media' => 72.67,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 7051,
                'apellido' => 'Bagioli',
                'nombre' => 'A.',
                'pais' => 'ITA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'escalador',
                'edad' => 26,
                'lla' => 68.16,
                'mon' => 73.70,
                'col' => 72.60,
                'cri' => 59.70,
                'pro' => 61.64,
                'pav' => 64.64,
                'spr' => 68.16,
                'acc' => 71.60,
                'des' => 67.16,
                'com' => 63.96,
                'ene' => 68.66,
                'res' => 71.96,
                'rec' => 67.00,
                'media' => 71.73,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 7040,
                'apellido' => 'Rex',
                'nombre' => 'L.',
                'pais' => 'BEL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'flandes',
                'edad' => 26,
                'lla' => 76.24,
                'mon' => 61.00,
                'col' => 73.10,
                'cri' => 62.30,
                'pro' => 64.31,
                'pav' => 77.10,
                'spr' => 72.78,
                'acc' => 72.86,
                'des' => 67.31,
                'com' => 75.24,
                'ene' => 72.86,
                'res' => 71.78,
                'rec' => 63.78,
                'media' => 75.13,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14183,
                'apellido' => 'Kielich',
                'nombre' => 'T.',
                'pais' => 'BEL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'flandes',
                'edad' => 26,
                'lla' => 72.12,
                'mon' => 63.00,
                'col' => 71.30,
                'cri' => 58.00,
                'pro' => 63.03,
                'pav' => 74.30,
                'spr' => 73.08,
                'acc' => 73.18,
                'des' => 72.03,
                'com' => 67.12,
                'ene' => 72.18,
                'res' => 71.08,
                'rec' => 65.08,
                'media' => 73.13,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 7122,
                'apellido' => 'Beullens',
                'nombre' => 'C.',
                'pais' => 'BEL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'flandes',
                'edad' => 28,
                'lla' => 72.30,
                'mon' => 61.70,
                'col' => 71.00,
                'cri' => 67.70,
                'pro' => 69.93,
                'pav' => 73.83,
                'spr' => 72.93,
                'acc' => 72.93,
                'des' => 67.83,
                'com' => 68.83,
                'ene' => 72.58,
                'res' => 71.30,
                'rec' => 66.58,
                'media' => 72.33,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 1939,
                'apellido' => 'Kristoff',
                'nombre' => 'A.',
                'pais' => 'NOR',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 38,
                'lla' => 77.60,
                'mon' => 57.00,
                'col' => 70.50,
                'cri' => 64.20,
                'pro' => 69.15,
                'pav' => 79.50,
                'spr' => 79.38,
                'acc' => 77.90,
                'des' => 69.15,
                'com' => 61.60,
                'ene' => 78.90,
                'res' => 77.38,
                'rec' => 72.38,
                'media' => 78.40,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 7303,
                'apellido' => 'Kooij',
                'nombre' => 'O.',
                'pais' => 'NED',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 24,
                'lla' => 76.18,
                'mon' => 60.00,
                'col' => 69.12,
                'cri' => 64.00,
                'pro' => 67.12,
                'pav' => 69.08,
                'spr' => 77.30,
                'acc' => 77.30,
                'des' => 65.08,
                'com' => 66.03,
                'ene' => 68.18,
                'res' => 69.08,
                'rec' => 64.03,
                'media' => 75.20,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 3060,
                'apellido' => 'Coquard',
                'nombre' => 'B.',
                'pais' => 'FRA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 33,
                'lla' => 68.08,
                'mon' => 62.00,
                'col' => 68.46,
                'cri' => 66.80,
                'pro' => 69.37,
                'pav' => 68.70,
                'spr' => 75.43,
                'acc' => 75.46,
                'des' => 67.61,
                'com' => 61.88,
                'ene' => 67.10,
                'res' => 71.63,
                'rec' => 62.87,
                'media' => 72.87,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 3777,
                'apellido' => 'Capiot',
                'nombre' => 'A.',
                'pais' => 'BEL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 32,
                'lla' => 72.28,
                'mon' => 63.00,
                'col' => 71.20,
                'cri' => 60.80,
                'pro' => 64.82,
                'pav' => 71.20,
                'spr' => 73.55,
                'acc' => 73.92,
                'des' => 65.82,
                'com' => 62.28,
                'ene' => 69.92,
                'res' => 66.55,
                'rec' => 66.55,
                'media' => 72.40,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 14327,
                'apellido' => 'Lund Andersen',
                'nombre' => 'T.',
                'pais' => 'DEN',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 23,
                'lla' => 72.34,
                'mon' => 62.00,
                'col' => 71.56,
                'cri' => 59.90,
                'pro' => 65.56,
                'pav' => 65.73,
                'spr' => 71.90,
                'acc' => 72.90,
                'des' => 64.73,
                'com' => 67.89,
                'ene' => 70.34,
                'res' => 71.73,
                'rec' => 64.89,
                'media' => 71.60,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 6422,
                'apellido' => 'Zijlaard',
                'nombre' => 'M.',
                'pais' => 'NED',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 26,
                'lla' => 71.62,
                'mon' => 56.80,
                'col' => 69.43,
                'cri' => 68.70,
                'pro' => 71.70,
                'pav' => 69.43,
                'spr' => 71.00,
                'acc' => 72.43,
                'des' => 67.77,
                'com' => 72.77,
                'ene' => 68.08,
                'res' => 69.62,
                'rec' => 62.08,
                'media' => 71.13,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 10502,
                'apellido' => 'Mahoudo',
                'nombre' => 'N.',
                'pais' => 'FRA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 23,
                'lla' => 69.64,
                'mon' => 63.00,
                'col' => 69.76,
                'cri' => 57.90,
                'pro' => 59.76,
                'pav' => 66.85,
                'spr' => 70.40,
                'acc' => 71.40,
                'des' => 67.85,
                'com' => 67.94,
                'ene' => 67.64,
                'res' => 68.85,
                'rec' => 60.94,
                'media' => 69.87,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 6386,
                'apellido' => 'Sajnok',
                'nombre' => 'S.',
                'pais' => 'POL',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 28,
                'lla' => 65.98,
                'mon' => 56.30,
                'col' => 65.12,
                'cri' => 65.10,
                'pro' => 67.95,
                'pav' => 66.03,
                'spr' => 71.63,
                'acc' => 71.63,
                'des' => 66.03,
                'com' => 58.36,
                'ene' => 62.66,
                'res' => 66.75,
                'rec' => 63.76,
                'media' => 69.07,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 6629,
                'apellido' => 'Viviani',
                'nombre' => 'A.',
                'pais' => 'ITA',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'sprinter',
                'edad' => 29,
                'lla' => 65.24,
                'mon' => 56.60,
                'col' => 66.76,
                'cri' => 56.30,
                'pro' => 62.67,
                'pav' => 63.01,
                'spr' => 70.81,
                'acc' => 70.81,
                'des' => 64.01,
                'com' => 63.47,
                'ene' => 60.60,
                'res' => 66.33,
                'rec' => 61.15,
                'media' => 68.33,
                'equipo_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        // registros de otros equipos
        $otrosCiclistas = [
            [
                'temporada' => 4,
                'clave_id' => 10,
                'apellido' => 'Inner',
                'nombre' => 'R.',
                'pais' => 'Irlanda',
                'pos_ini' => null,
                'pos_fin' => null,
                'victorias' => null,
                'pts' => null,
                'especialidad' => 'croner',
                'edad' => 31,
                'lla' => 72.00,
                'mon' => 60.00,
                'col' => 66.00,
                'cri' => 70.00,
                'pro' => 70.00,
                'pav' => 72.00,
                'spr' => 69.00,
                'acc' => 68.00,
                'des' => 69.00,
                'com' => 64.00,
                'ene' => 69.00,
                'res' => 68.00,
                'rec' => 68.00,
                'media' => 70.33,
                'equipo_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 1,
                'apellido' => 'De los Palotes',
                'nombre' => 'Perico',
                'pais' => 'España',
                'pos_ini' => 5,
                'pos_fin' => 1,
                'victorias' => 2,
                'pts' => 75.12345678,
                'especialidad' => 'escalador',
                'edad' => 28,
                'lla' => 78.5,
                'mon' => 79.8,
                'col' => 80.2,
                'cri' => 66.1,
                'pro' => 73.9,
                'pav' => 63.3,
                'spr' => 55.2,
                'acc' => 71.1,
                'des' => 79.9,
                'com' => 72.2,
                'ene' => 80.0,
                'res' => 81.3,
                'rec' => 82.4,
                'media' => 75.60,
                'equipo_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 2,
                'apellido' => 'Piccolo',
                'nombre' => 'Rocco',
                'pais' => 'Italia',
                'pos_ini' => 10,
                'pos_fin' => 3,
                'victorias' => 1,
                'pts' => 68.23456789,
                'especialidad' => 'croner',
                'edad' => 23,
                'lla' => 72.5,
                'mon' => 65.8,
                'col' => 70.2,
                'cri' => 63.1,
                'pro' => 72.9,
                'pav' => 64.3,
                'spr' => 67.2,
                'acc' => 69.1,
                'des' => 74.9,
                'com' => 78.2,
                'ene' => 76.0,
                'res' => 75.3,
                'rec' => 77.4,
                'media' => 72.60,
                'equipo_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 4,
                'apellido' => 'Gomes',
                'nombre' => 'Nuno',
                'pais' => 'Portugal',
                'pos_ini' => 1,
                'pos_fin' => 3,
                'victorias' => 1,
                'pts' => 68.23456789,
                'especialidad' => 'ardenas',
                'edad' => 40,
                'lla' => 72.5,
                'mon' => 65.8,
                'col' => 70.2,
                'cri' => 63.1,
                'pro' => 72.9,
                'pav' => 64.3,
                'spr' => 67.2,
                'acc' => 69.1,
                'des' => 74.9,
                'com' => 78.2,
                'ene' => 76.0,
                'res' => 75.3,
                'rec' => 77.4,
                'media' => 72.60,
                'equipo_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'temporada' => 4,
                'clave_id' => 3,
                'apellido' => 'Horner',
                'nombre' => 'Cristiano',
                'pais' => 'Italia',
                'pos_ini' => 7,
                'pos_fin' => 2,
                'victorias' => 4,
                'pts' => 70.12345678,
                'especialidad' => 'flandes',
                'edad' => 26,
                'lla' => 76.4,
                'mon' => 78.3,
                'col' => 82.1,
                'cri' => 68.1,
                'pro' => 69.7,
                'pav' => 60.3,
                'spr' => 62.4,
                'acc' => 77.0,
                'des' => 75.5,
                'com' => 79.6,
                'ene' => 77.9,
                'res' => 80.2,
                'rec' => 81.1,
                'media' => 75.50,
                'equipo_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        $ciclistas = array_merge($ciclistas, $otrosCiclistas);

        // Insertar ciclistas calculando `u24` y `conti`
        foreach ($ciclistas as $ciclista) {
            // Calcula `u24`: Edad <= 24 y media < 75
            $ciclista['u24'] = ($ciclista['edad'] <= 24 && $ciclista['media'] < 75);

            // Calcula `conti`: Es `true` si todos los atributos relevantes son menores que 78
            $valores = [
                $ciclista['lla'], $ciclista['mon'], $ciclista['col'], $ciclista['cri'], 
                $ciclista['pro'], $ciclista['pav'], $ciclista['spr'], $ciclista['acc'], 
                $ciclista['des'], $ciclista['com'], $ciclista['ene'], $ciclista['res'], 
                $ciclista['rec']
            ];
            $ciclista['conti'] = !collect($valores)->contains(fn($value) => $value >= 78);

            // Inserta el ciclista en la base de datos con los campos calculados
            DB::table('ciclistas')->insert($ciclista);
        }
    }
}
