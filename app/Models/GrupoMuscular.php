<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMuscular extends Model
{
    protected $table = 'grupos_musculares';

    protected $fillable = ['nombre'];

    public function diaGrupos()
    {
        return $this->hasMany(DiaGrupo::class);
    }

    public function dias()
    {
        return $this->belongsToMany(Dia::class, 'dia_grupo')
                    ->withPivot('orden')
                    ->withTimestamps();
    }
}
