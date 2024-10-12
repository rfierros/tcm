<?php

use App\Http\Controllers\CiclistaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

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
