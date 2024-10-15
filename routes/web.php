<?php

use App\Http\Controllers\CiclistaController;
use App\Http\Controllers\EquipoController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/reglamento', 'reglamento')->name('reglamento');

Route::get('equipos', [EquipoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('equipos'); 

Route::get('mi_equipo', [CiclistaController::class, 'miEquipo'])
    ->middleware(['auth', 'verified'])
    ->name('mi_equipo'); 

Route::get('ciclistas', [CiclistaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('ciclistas'); 

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
