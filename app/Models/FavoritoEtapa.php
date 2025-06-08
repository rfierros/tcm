<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritoEtapa extends Model
{
    use HasFactory;

    // 1) Nombre de la tabla (no sigue la convención plural)
    protected $table = 'favoritos_etapa';

    // 2) Permitir inserción masiva de estos campos
    protected $fillable = [
        'temporada',
        'num_carrera',
        'num_etapa',
        'cod_ciclista',
        'orden',
    ];

    // 3) Deshabilitamos incremento compuesto; usamos id autoincremental
    public $incrementing = true;
    protected $primaryKey = 'id';

    // 4) Relaciones:

    /**
     * 4.1) Relación hacia la etapa "padre".
     *     Clave compuesta en this: ['temporada','num_carrera','num_etapa']
     *     Clave compuesta en Etapa: ['temporada','num_carrera','num_etapa']
     */
    public function etapa()
    {
        return $this->belongsTo(
            Etapa::class,
            ['temporada', 'num_carrera', 'num_etapa'],
            ['temporada', 'num_carrera', 'num_etapa']
        );
    }

    /**
     * 4.2) Relación hacia el corredor al que se refiere.
     */
    public function corredor()
    {
        return $this->belongsTo(
            Corredor::class,
            'cod_ciclista',
            'id'
        );
    }
}
