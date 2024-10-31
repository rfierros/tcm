<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;  
use InvalidArgumentException;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = ['bloque', 'nombre', 'num_etapas', 'categoria', 'tipo', 'temporada', 'dia_inicio'];

    // Valores permitidos para 'categoria' y 'tipo'
    const CATEGORIAS = ['U24', 'WT', 'Conti'];
    const TIPOS = ['Vuelta', 'Clasica', 'Monumento', 'Continental', 'GV'];

    // Accessor para validar el valor de 'categoria'
    public function setCategoriaAttribute($value)
    {
        if (!in_array($value, self::CATEGORIAS)) {
            throw new InvalidArgumentException("La categoría $value no es válida.");
        }
        $this->attributes['categoria'] = $value;
    }

    // Accessor para validar el valor de 'tipo'
    public function setTipoAttribute($value)
    {
        if (!in_array($value, self::TIPOS)) {
            throw new InvalidArgumentException("El tipo $value no es válido.");
        }
        $this->attributes['tipo'] = $value;
    }

    public function calendario(): HasMany
    {
        return $this->hasMany(Calendario::class, 'carrera_id');
    }

    public function ciclistas(): BelongsToMany
    {
        return $this->belongsToMany(Ciclista::class, 'carrera_ciclista')
                    ->withPivot(['inscrito_at'])
                    ->withTimestamps();
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(Resultado::class, 'carrera_id');
    }

    // Función para inscribir un ciclista en la carrera, validando conflictos de fechas
    public function inscribirCiclista(Ciclista $ciclista)
    {
        $diasCarrera = range($this->dia_inicio, $this->dia_inicio + $this->num_etapas - 1);

        // Verificar conflictos con otras carreras en la misma temporada
        $conflictos = DB::table('calendarios')
            ->join('carrera_ciclista', 'calendarios.carrera_id', '=', 'carrera_ciclista.carrera_id')
            ->where('carrera_ciclista.ciclista_id', $ciclista->id)
            ->where('calendarios.temporada', $this->temporada)
            ->whereIn('calendarios.dia', $diasCarrera)
            ->exists();

        if ($conflictos) {
            return "El ciclista no puede inscribirse debido a un conflicto de fechas en esta temporada.";
        }

        // Si no hay conflictos, inscribir el ciclista
        $this->ciclistas()->attach($ciclista->id, ['inscrito_at' => now()]);
    }

    public function maxCorredoresPermitidos()
    {
        if ($this->tipo === 'GV') {
            return 8;
        } elseif ($this->categoria === 'U24') {
            return 5;
        }
        return 7;
    }

    // Validar inscripción de los corredores y conflictos
    public function validarInscripcion(array $ciclistasIds)
    {
        $maxPermitido = $this->maxCorredoresPermitidos();
        if (count($ciclistasIds) > $maxPermitido) {
            throw new \Exception("No puedes inscribir más de $maxPermitido corredores en esta carrera.");
        }

        foreach ($ciclistasIds as $ciclistaId) {
            if ($this->existeConflictoDeCalendario($ciclistaId)) {
                throw new \Exception("El ciclista con ID $ciclistaId ya está inscrito en una carrera que se solapa.");
            }
        }

        return true;
    }

    public function corredoresInscritos(int $equipoId)
    {
        return Resultado::where('carrera_id', $this->id)
                        ->where('equipo_id', $equipoId)
                        ->get();
    }
}

