<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroEntrenamiento extends Model
{
    protected $table = 'registro_entrenamientos';

    protected $fillable = [
        'user_id', 'dia_plantilla_id', 'fecha_real', 'ejercicio_id',
        'serie_numero', 'repeticiones_realizadas', 'peso_realizado',
        'completado', 'notas'
    ];

    protected $casts = [
        'fecha_real' => 'date',
        'completado' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diaPlantilla()
    {
        return $this->belongsTo(DiaPlantilla::class);
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }
}
