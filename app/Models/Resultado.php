<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = ['carrera_id', 'ciclista_id', 'temporada', 'etapa', 'posicion', 'tiempo'];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function ciclista(): BelongsTo
    {
        return $this->belongsTo(Ciclista::class, 'ciclista_id');
    }
}

