<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    protected $table = 'calendario'; // Especificar el nombre de la tabla si es diferente de 'calendarios'

    protected $fillable = ['dia', 'temporada'];

    // Relación de muchos a muchos con competiciones
    public function competiciones()
    {
        return $this->belongsToMany(Competicion::class, 'calendario_competiciones')
            ->withPivot('temporada')
            ->withTimestamps();
    }
}
