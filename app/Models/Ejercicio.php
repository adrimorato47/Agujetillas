<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';
    
    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'video_url'
    ];
    
    protected $casts = [
        'user_id' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function diaEjercicios()
    {
        return $this->hasMany(DiaEjercicio::class);
    }
}