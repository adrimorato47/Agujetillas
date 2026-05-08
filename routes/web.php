<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\GrupoMuscularController;
use App\Http\Controllers\DiaPlantillaController;
use App\Http\Controllers\DiaGrupoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('ejercicios', EjercicioController::class);
    Route::resource('grupos-musculares', GrupoMuscularController::class);
    Route::resource('dias-plantilla', DiaPlantillaController::class);
    Route::resource('dias-grupo', DiaGrupoController::class);

});

require __DIR__.'/auth.php';
