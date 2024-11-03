<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = ['carrera_id', 'temporada', 'dia', 'perfil', 'imagen'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
}
