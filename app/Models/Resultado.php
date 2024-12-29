<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = ['temporada', 'num_carrera', 'etapa', 'ciclista_id', 'equipo_id', 'posicion', 'pos_gral', 'gral_reg', 'gral_mon', 'gral_jov', 'tiempo', 'pts'];


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
        return $this->belongsTo(Ciclista::class, 'ciclista_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public static function crearResultadosParaInscripcion(int $carreraId, array $ciclistasIds, int $equipoId, int $temporada, int $numEtapas)
    {
        foreach ($ciclistasIds as $ciclistaId) {
            // Crear un registro en 'resultados' por cada etapa
            for ($etapa = 1; $etapa <= $numEtapas; $etapa++) {
                self::create([
                    'carrera_id' => $carreraId,
                    'etapa' => $etapa,
                    'ciclista_id' => $ciclistaId,
                    'equipo_id' => $equipoId,
                    'posicion' => 0, // Posición inicial de 0
                    'temporada' => $temporada,
                ]);
            }
        }
    }
}

