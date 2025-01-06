<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = ['temporada', 'num_carrera', 'etapa', 'cod_ciclista', 'cod_equipo', 'posicion', 'pos_gral', 'gral_reg', 'gral_mon', 'gral_jov', 'tiempo', 'pts'];


    public function carrera()
    {
        return $this->belongsTo(
            Carrera::class,
            ['temporada', 'num_carrera'],
            ['temporada', 'num_carrera']
        );
    }

    public function ciclista(): BelongsTo
    {
        return $this->belongsTo(Ciclista::class, 'cod_ciclista', 'cod_ciclista');
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'cod_equipo', 'cod_equipo');
    }

    public static function crearResultadosParaInscripcion(int $carreraId, array $codsCiclistas, int $codEquipo, int $temporada, int $numEtapas)
    {
        foreach ($codsCiclistas as $codCiclista) {
            // Crear un registro en 'resultados' por cada etapa
            for ($etapa = 1; $etapa <= $numEtapas; $etapa++) {
                self::create([
                    'carrera_id' => $carreraId,
                    'etapa' => $etapa,
                    'cod_ciclista' => $codCiclista,
                    'cod_equipo' => $codEquipo,
                    'posicion' => 0, // Posición inicial de 0
                    'temporada' => $temporada,
                ]);
            }
        }
    }
}

