<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'dia_ejercicio_id',
        'numero_serie',
        'repeticiones',
        'peso'
    ];

    public function diaEjercicio()
    {
        return $this->belongsTo(DiaEjercicio::class);
    }
}
