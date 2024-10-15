<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competicion extends Model
{
    protected $table = 'competiciones'; // Especificar el nombre de la tabla

    protected $fillable = ['nombre', 'tipo', 'duracion', 'temporada'];

    // Relación de muchos a muchos con calendario
    public function calendarios()
    {
        return $this->belongsToMany(Calendario::class, 'calendario_competiciones')
            ->withPivot('temporada')
            ->withTimestamps();
    }
}
