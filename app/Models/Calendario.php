<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;  

class Calendario extends Model
{
    use HasFactory;

    protected $fillable = ['carrera_id', 'dia', 'temporada', 'etapa'];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function existeConflictoDeCalendario(int $ciclistaId): bool
    {
        $diasCarrera = range($this->dia_inicio, $this->dia_inicio + $this->num_etapas - 1);

        return DB::table('calendarios')
            ->join('resultados', 'calendarios.carrera_id', '=', 'resultados.carrera_id')
            ->where('resultados.ciclista_id', $ciclistaId)
            ->where('calendarios.temporada', $this->temporada)
            ->whereIn('calendarios.dia', $diasCarrera)
            ->exists();
    }
}

