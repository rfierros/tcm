<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['cod_equipo', 'temporada', 'nombre_equipo', 'nombre_en_bd', 'user_id', 'categoria'];

    // Relación con el modelo User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ciclistas(): HasMany
    {
        return $this->hasMany(Ciclista::class, 'cod_equipo')
                    ->whereColumn('ciclistas.temporada', 'equipos.temporada');
    }

    /**
     * Relación con inscripciones.
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'cod_equipo')
                    ->whereColumn('inscripciones.temporada', 'equipos.temporada');
    }
    
    /**
     * Relación con el modelo Resultado.
     */
    public function resultados(): HasMany
    {
        return $this->hasMany(Resultado::class, 'cod_equipo', 'cod_equipo')
                    ->whereColumn('resultados.temporada', 'equipos.temporada');
    }
}