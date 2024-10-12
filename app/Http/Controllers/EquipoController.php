<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipoController extends Controller
{
    public function index(): View
    {
        return view('equipos', [
            //
        ]);
    }
}
