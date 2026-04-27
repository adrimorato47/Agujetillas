<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // En tu modelo User.php existente, añade:

    public function diasPlantilla()
    {
        return $this->hasMany(DiaPlantilla::class);
    }

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class);
    }

    public function gruposMusculares()
    {
        return $this->hasMany(GrupoMuscular::class);
    }

    public function registrosEntrenamientos()
    {
        return $this->hasMany(RegistroEntrenamiento::class);
    }
}
