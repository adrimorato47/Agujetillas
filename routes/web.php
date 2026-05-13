<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\GrupoMuscularController;
use App\Http\Controllers\DiaPlantillaController;
use App\Http\Controllers\DiaGrupoController;

Route::get('/test-controller', function () {
    return class_exists('App\Http\Controllers\DiaEjercicioController') ? 'Existe' : 'No existe';
});

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

    Route::post('/dia-grupo', [DiaGrupoController::class, 'store'])->name('dia-grupo.store');
    Route::delete('/dia-grupo/{id}', [DiaGrupoController::class, 'destroy'])->name('dia-grupo.destroy');

    //Route::post('/dia-ejercicio', [DiaEjercicioController::class, 'store'])->name('dia-ejercicio.store');
    //Route::delete('/dia-ejercicio/{id}', [DiaEjercicioController::class, 'destroy'])->name('dia-ejercicio.destroy');
    Route::post('/dia-ejercicio', 'App\Http\Controllers\DiaEjercicioController@store')->name('dia-ejercicio.store');
    Route::delete('/dia-ejercicio/{id}', 'App\Http\Controllers\DiaEjercicioController@destroy')->name('dia-ejercicio.destroy');

});

require __DIR__.'/auth.php';
