<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';

    protected $fillable = ['nombre'];

    public function diaEjercicios()
    {
        return $this->hasMany(DiaEjercicio::class);
    }
}
