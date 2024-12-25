<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = ['temporada', 'num_carrera', 'num_etapa', 'slug', 'nombre', 'km', 'dia', 'perfil', 'tipo', 'imagen'];

    /**
     * Relación con la tabla `Carreras`.
     * Basada en las claves compuestas: `temporada` y `num_carrera`.
     */
    public function carrera()
    {
        return $this->belongsTo(
            Carrera::class,
            ['temporada', 'num_carrera'],
            ['temporada', 'num_carrera']
        );
    }
}
