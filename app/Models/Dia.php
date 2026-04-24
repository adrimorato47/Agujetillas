<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $table = 'dias';

    protected $fillable = ['nombre'];

    public function diaGrupos()
    {
        return $this->hasMany(DiaGrupo::class);
    }

    public function gruposMusculares()
    {
        return $this->belongsToMany(GrupoMuscular::class, 'dia_grupo')
                    ->withPivot('orden')
                    ->withTimestamps();
    }
}
