<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CiclistaController extends Controller
{
    public function index(): View
    {
        return view('ciclistas', [
            //
        ]);
    }

    public function miEquipo()
    {
        return view('my-ciclistas', [
            //
        ]);
    }
}
