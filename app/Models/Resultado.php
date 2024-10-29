<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = ['carrera_id', 'ciclista_id', 'equipo_id', 'etapa', 'posicion', 'temporada', 'tiempo'];


    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function ciclista(): BelongsTo
    {
        return $this->belongsTo(Ciclista::class, 'ciclista_id');
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

