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
        'cod_ciclista', 'temporada', 'cod_equipo', 'nombre', 'apellido', 'nom_ape', 'nom_abrev', 'pais', 'pos_ini', 'pos_fin', 'pts', 'especialidad', 'edad', 
        'lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com',
        'ene', 'res', 'rec', 'media', 'conti', 'u24'
    ];

    // Relación de pertenencia a un equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'cod_equipo', 'cod_equipo');
    }

    public function resultados()
    {
        return $this->hasMany(Resultado::class, 'cod_ciclista', 'cod_ciclista');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'cod_ciclista', 'cod_ciclista');
    }

    public function calcularSwitches(): void
    {
        // Regla para el campo `u24`
        $this->u24 = ($this->edad <= 24 && $this->media < 75);

        // Regla para el campo `conti`
        $valores = [
            $this->lla, $this->mon, $this->col, $this->cri, $this->pro,
            $this->pav, $this->spr, $this->acc, $this->des, $this->com,
            $this->ene, $this->res, $this->rec
        ];
        
        // Si algún valor es >= 78, conti es false; en caso contrario, true
        $this->conti = !collect($valores)->contains(fn($value) => $value >= 78);
    }
    /**
     * Registra el evento `saving` para calcular los valores de `conti` y `u24` automáticamente antes de guardar.
     */
    protected static function boot()
    {
        parent::boot();

        // Evento `saving` para calcular los valores antes de guardar
        static::saving(function ($ciclista) {
            $ciclista->calcularSwitches();
        });
    }
}
