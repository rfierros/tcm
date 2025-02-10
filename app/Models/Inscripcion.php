<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = ['temporada', 'num_carrera', 'cod_ciclista', 'cod_equipo', 'sancion', 'forma'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'num_carrera', 'num_carrera');
    }

    public function ciclista(): BelongsTo
    {
        return $this->belongsTo(Ciclista::class, 'cod_ciclista', 'cod_ciclista');
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'cod_equipo', 'cod_equipo');
    }
}
