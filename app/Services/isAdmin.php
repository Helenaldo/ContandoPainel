<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Verifica se o usuário logado é um administrador.
     *
     * @return bool
     */
    public static function check(): bool
    {
        $user = Auth::user();

        return $user && $user->status === 'Administrador';
    }
}
