<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaEjercicio extends Model
{
    protected $table = 'dia_ejercicio';

    protected $fillable = ['dia_grupo_id', 'ejercicio_id', 'orden_ejercicio'];

    public function diaGrupo()
    {
        return $this->belongsTo(DiaGrupo::class);
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }

    public function series()
    {
        return $this->hasMany(Serie::class);
    }
}
