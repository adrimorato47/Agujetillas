<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriePlantilla extends Model
{
    protected $table = 'series_plantilla';
    
    protected $fillable = [
        'dia_ejercicio_id',
        'numero_serie',
        'repeticiones_planificadas',
        'peso_planificado',
        'descanso_segundos'
    ];
    
    protected $casts = [
        'peso_planificado' => 'decimal:2',
        'repeticiones_planificadas' => 'integer',
        'numero_serie' => 'integer',
        'descanso_segundos' => 'integer'
    ];
    
    public function diaEjercicio()
    {
        return $this->belongsTo(DiaEjercicio::class);
    }
}