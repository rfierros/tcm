<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ciclista extends Model
{
    use HasFactory;

    protected $table = 'ciclistas'; // Nombre de la tabla

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre', 'pais', 'pos_ini', 'pos_fin', 'pts', 'especialidad', 'edad', 
        'lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com',
        'ene', 'res', 'res', 'media', 'equipo_id'
    ];

    // Relación de pertenencia a un equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id');
    }     
}
