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
        $etapas = $carrera->etapas()->orderBy('num_etapa')->get();
        $slugCarrera = $carrera->slug;

        return view('etapas', compact('carrera', 'etapas', 'slugCarrera'));
    }

    // Muestra la información de una etapa específica
    public function show(Request $request, Carrera $carrera, Etapa $etapa)
    {
        // Obtener los parámetros directamente desde la URL
        $slugCarrera = $request->route('carrera');
        $etapa = $request->route('etapa');
        // dd($slugCarrera);
        dd($request);
        // Validar que la etapa pertenezca a la carrera seleccionada
        if ($etapa->carrera_id !== $carrera->id) {
            abort(404); // Si la etapa no pertenece a la carrera, mostramos 404
        }

        return view('livewire.etapas.show', compact('carrera', 'etapa'));
    }
}
