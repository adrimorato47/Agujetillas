<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaPlantilla extends Model
{
    protected $table = 'dias_plantilla';

    protected $fillable = ['user_id', 'fecha', 'nombre'];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gruposMusculares()
    {
        return $this->belongsToMany(GrupoMuscular::class, 'dia_grupo')
                ->withPivot('id', 'orden')
                ->withTimestamps();
    }

    public function registros()
    {
        return $this->hasMany(RegistroEntrenamiento::class, 'dia_plantilla_id');
    }

    public function diaGrupos()
    {
        return $this->hasMany(DiaGrupo::class, 'dia_plantilla_id');
    }
}
