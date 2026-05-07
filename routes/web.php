<?php

use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\GrupoMuscularController;
use App\Http\Controllers\DiaPlantillaController;
use App\Http\Controllers\DiaGrupoController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de ejercicios (recurso completo)
    Route::resource('ejercicios', EjercicioController::class);

    Route::resource('grupos-musculares', GrupoMuscularController::class);

    // Rutas de días plantilla (recurso completo)
    Route::resource('dias-plantilla', DiaPlantillaController::class);

    // Para asignar grupos a un día específico
    Route::post('/dia-grupo', [DiaGrupoController::class, 'store'])->name('dia-grupo.store');
    Route::delete('/dia-grupo/{id}', [DiaGrupoController::class, 'destroy'])->name('dia-grupo.destroy');

});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php'; // las rutas de Breeze (login, register...)


