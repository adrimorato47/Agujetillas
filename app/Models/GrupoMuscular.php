<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMuscular extends Model
{
    protected $table = 'grupos_musculares';
    protected $fillable = ['user_id', 'nombre'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}