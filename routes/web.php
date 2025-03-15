<?php

use App\Http\Controllers\CiclistaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EtapaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/reglamento', 'reglamento')->name('reglamento');

Route::get('draft', [DraftController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('draft'); 

Route::get('equipos', [EquipoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('equipos'); 

Route::get('mi_equipo', [CiclistaController::class, 'miEquipo'])
    ->middleware(['auth', 'verified'])
    ->name('mi_equipo'); 

Route::get('ciclistas', [CiclistaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('ciclistas'); 
Route::get('/etapas/{carrera:slug}/{etapa}', [EtapaController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('etapas');
Route::get('/etapas/{carrera:slug}', [EtapaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('etapas');
// Route::get('/etapas/{carrera:slug}', [EtapaController::class, 'index'])
// ->middleware(['auth', 'verified'])
// ->name('etapas.index');
Route::get('carreras', [CarreraController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('carreras'); 

Route::get('calendarios', [CalendarioController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('calendarios'); 

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
