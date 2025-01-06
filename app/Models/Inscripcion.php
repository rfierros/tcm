<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'cod_equipo', 'cod_equipo');
    }
}
