<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmailVerificationController extends Controller
{
    public function __invoke(EmailVerificationRequest $request)
    {
        $tenant = $request->only([
            'contrato',
            'user_name',
            'senha_provisoria',
            'password',
            'password_confirmation',
        ]);
        $tenant = Tenant::with('users')->where('contrato', $request->input('contrato'))->first();

        $user = User::find($tenant->users[0]->id);

        $data = [
            'name' => $request->user_name,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ];

        $user->fill($data)->save();

        return response()->json(['message' => 'Usuário verificado e alterado com sucesso!']);


    }
}
