<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'bloque', 'num_carrera', 'nombre', 'num_etapas', 'categoria', 'tipo', 'temporada', 'dia_inicio',
    ];

    // Valores permitidos para 'categoria' y 'tipo'
    const CATEGORIAS = ['U24', 'WT', 'Conti'];
    const TIPOS = ['Vuelta', 'Clásica', 'Monumento', 'Continental', 'GV'];

    /**
     * Validación del atributo `categoria`.
     */
    public function setCategoriaAttribute($value)
    {
        if (!in_array($value, self::CATEGORIAS)) {
            throw new InvalidArgumentException("La categoría $value no es válida.");
        }
        $this->attributes['categoria'] = $value;
    }

    /**
     * Validación del atributo `tipo`.
     */
    public function setTipoAttribute($value)
    {
        if (!in_array($value, self::TIPOS)) {
            throw new InvalidArgumentException("El tipo $value no es válido.");
        }
        $this->attributes['tipo'] = $value;
    }

    /**
     * Relación con el modelo `Inscripcion`.
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'num_carrera', 'num_carrera')
            ->where('temporada', $this->temporada);
    }

    /**
     * Relación con el modelo `Ciclista` a través de `Inscripcion`.
     */
    public function ciclistas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Ciclista::class,
            Inscripcion::class,
            'num_carrera', // Foreign key en Inscripciones
            'cod_ciclista', // Foreign key en Ciclistas
            'num_carrera', // Local key en Carrera
            'cod_ciclista' // Local key en Inscripciones
        )->where('inscripciones.temporada', $this->temporada);
    }

    /**
     * Relación con el modelo `Etapa`.
     */
    public function etapas(): HasMany
    {
        return $this->hasMany(Etapa::class, 'num_carrera', 'num_carrera')
            ->where('temporada', $this->temporada);
    }

    /**
     * Cambia la clave para buscar rutas.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Inscribir un ciclista en la carrera validando conflictos de calendario.
     */
    public function inscribirCiclista(Ciclista $ciclista)
    {
        $diasCarrera = range($this->dia_inicio, $this->dia_inicio + $this->num_etapas - 1);

        // Verificar conflictos con otras carreras en la misma temporada
        $conflictos = $this->existeConflictoDeCalendario($ciclista->cod_ciclista);

        if ($conflictos) {
            return "El ciclista no puede inscribirse debido a un conflicto de fechas en esta temporada.";
        }

        // Crear la inscripción si no hay conflictos
        Inscripcion::create([
            'temporada' => $this->temporada,
            'num_carrera' => $this->num_carrera,
            'cod_ciclista' => $ciclista->cod_ciclista,
            'cod_equipo' => $ciclista->cod_equipo,
            'inscrito_at' => now(),
        ]);
    }

    /**
     * Determinar el número máximo de corredores permitidos en esta carrera.
     */
    public function maxCorredoresPermitidos()
    {
        if ($this->tipo === 'GV') {
            return 8;
        } elseif ($this->categoria === 'U24') {
            return 5;
        }
        return 7;
    }

    /**
     * Validar las inscripciones de un conjunto de corredores.
     */
    public function validarInscripcion(array $ciclistasCodigos)
    {
        $maxPermitido = $this->maxCorredoresPermitidos();
        if (count($ciclistasCodigos) > $maxPermitido) {
            throw new \Exception("No puedes inscribir más de $maxPermitido corredores en esta carrera.");
        }

        foreach ($ciclistasCodigos as $codCiclista) {
            if ($this->existeConflictoDeCalendario($codCiclista)) {
                throw new \Exception("El ciclista con cod_ciclista $codCiclista ya está inscrito en una carrera que se solapa.");
            }
        }

        return true;
    }

    /**
     * Verificar si un ciclista tiene conflictos de calendario con esta carrera.
     */
    private function existeConflictoDeCalendario($codCiclista)
    {
        $diasCarrera = range($this->dia_inicio, $this->dia_inicio + $this->num_etapas - 1);

        return DB::table('inscripciones')
            ->join('carreras', function ($join) {
                $join->on('inscripciones.num_carrera', '=', 'carreras.num_carrera')
                    ->where('inscripciones.temporada', $this->temporada);
            })
            ->where('inscripciones.cod_ciclista', $codCiclista)
            ->whereIn('carreras.dia_inicio', $diasCarrera)
            ->exists();
    }
}
