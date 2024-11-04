<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Etapa;
use Illuminate\Http\Request;

class EtapaController extends Controller
{
    // Muestra las etapas de una carrera específica
    public function index(Carrera $carrera)
    {
        // Obtener las etapas de la carrera
        $etapas = $carrera->etapas; // Esto asume que existe una relación 'etapas' en el modelo Carrera
        return view('livewire.etapas.list', compact('carrera', 'etapas'));
    }

    // Muestra la información de una etapa.
    public function show(Carrera $carrera, Etapa $etapa)
    {
        // Validar que la etapa pertenezca a la carrera seleccionada
        if ($etapa->carrera_id !== $carrera->id) {
            abort(404); // Si la etapa no pertenece a la carrera, mostramos 404
        }

        return view('livewire.etapas.show', compact('carrera', 'etapa'));
    }

}
