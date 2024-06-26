<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request) {
        $user = $request->only([
            'name',
            'email',
            'password',
            'avatar', // Imagem do usuário
            'status', // Administrador ou Operador
            'ativo'// boolean
        ]);

        $user['status'] = 'Administrador';

        $user = User::create($user);

        return $user;
    }

}
