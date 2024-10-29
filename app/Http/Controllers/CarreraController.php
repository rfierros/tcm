<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Resultado;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inscribirCorredores(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);
        $equipoId = $request->user()->equipo->id; // ID del equipo del usuario
        $ciclistas = $request->user()->equipo->ciclistas; // Obtener corredores del equipo del jugador

        return view('carreras.inscribir', compact('carrera', 'ciclistas'));
    }

    public function storeInscripcion(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);
        $equipoId = $request->user()->equipo->id;
        $ciclistasIds = $request->input('ciclistas');

        try {
            // Validar inscripción usando el modelo Carrera
            $carrera->validarInscripcion($ciclistasIds);

            // Registrar la inscripción en el modelo Resultado
            Resultado::crearResultadosParaInscripcion($carrera->id, $ciclistasIds, $equipoId, $carrera->temporada, $carrera->num_etapas);

            return redirect()->route('carreras.show', $id)->with('success', 'Inscripción realizada con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


}
