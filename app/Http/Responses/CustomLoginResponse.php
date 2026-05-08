<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Esta es la magia: redirige a la ruta que se llame 'dashboard'
        return redirect()->intended(route('dashboard'));
    }
}