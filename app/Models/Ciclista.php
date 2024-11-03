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
        'temporada', 'nombre', 'pais', 'pos_ini', 'pos_fin', 'pts', 'especialidad', 'edad', 
        'lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com',
        'ene', 'res', 'media', 'equipo_id', 'conti', 'u24'
    ];

    // Relación de pertenencia a un equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
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
