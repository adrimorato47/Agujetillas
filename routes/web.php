<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\SeriePlantillaController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::resource('ejercicios', EjercicioController::class)->middleware('auth');

Route::prefix('series-plantilla')->group(function () {
    Route::get('/dia-ejercicio/{diaEjercicioId}', [SeriePlantillaController::class, 'index']);
    Route::post('/', [SeriePlantillaController::class, 'store']);
    Route::get('/{id}', [SeriePlantillaController::class, 'show']);
    Route::put('/{id}', [SeriePlantillaController::class, 'update']);
    Route::delete('/{id}', [SeriePlantillaController::class, 'destroy']);
    Route::get('/dia-plantilla/{diaPlantillaId}', [SeriePlantillaController::class, 'getByDiaPlantilla']);
});