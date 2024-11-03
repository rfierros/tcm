<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class EtapaController extends Controller
{
    // Muestra las etapas de una carrera específica
    public function index($carreraId)
    {
        $carrera = Carrera::with('etapas')->findOrFail($carreraId);
        return view('livewire.etapas.list', compact('carrera'));
    }
}
