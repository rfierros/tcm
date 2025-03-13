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
        'ene', 'res', 'rec', 'media', 'es_u24', 'es_conti', 'es_pro'
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
        // Regla para el campo `es_u24`
        $this->es_u24 = ($this->edad <= 24 && $this->media < 75);

        // Regla para el campo `es_conti` y `es_pro`
        $valores = [
            $this->lla, $this->mon, $this->col, $this->cri, $this->pro,
            $this->pav, $this->spr, $this->acc, $this->des, $this->com,
            $this->ene, $this->res, $this->rec
        ];
        
        // Si algún valor es >= 78, es_conti es false; en caso contrario, true
        $this->es_conti = !collect($valores)->contains(fn($value) => $value >= 78);

        // Si algún valor es >= 80, es_pro es false; en caso contrario, true
        $this->es_pro = !collect($valores)->contains(fn($value) => $value >= 80);
    }
    /**
     * Registra el evento `saving` para calcular los valores de `es_conti`, `es_pro` y `es_u24` automáticamente antes de guardar.
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
