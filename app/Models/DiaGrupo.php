<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaGrupo extends Model
{
    protected $table = 'dia_grupo';
    protected $fillable = ['dia_plantilla_id', 'grupo_muscular_id', 'orden'];
    protected $casts = ['orden' => 'integer'];

    public function diaPlantilla()
    {
        return $this->belongsTo(DiaPlantilla::class);
    }

    public function grupoMuscular()
    {
        return $this->belongsTo(GrupoMuscular::class);
    }
}