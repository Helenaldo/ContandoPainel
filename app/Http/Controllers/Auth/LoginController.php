<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Pega o usuário que estar tentando se logar
        $user = User::where('email', $request->email)->first();

        // Valida se exite e se senha estar correta
        if(! $user ||! Hash::check($request->password, $user->password) || $user->ativo == false) {
            return response()->json([
                'success' => false,
                'message' => 'Falha na autenticação de usuário.'
            ]);
        }

        // Se correto, retorna o $token
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }
}
