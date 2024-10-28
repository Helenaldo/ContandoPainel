<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\isAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Captura o valor do parâmetro 'ativo' da query string, se existir
        $ativo = $request->input('ativo', true);
        $users = User::query();

        // Se 'ativo' for passado, filtra os usuários por este valor
        if ($ativo) {
            $users = $users->where('ativo', $ativo);
        }

        $users = $users->get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if (!isAdmin::check()) {
            return response()->json(['message' => 'Você não é um administrador'], JsonResponse::HTTP_FORBIDDEN);
        }
        try {
            $user = $request->only([
                'name',
                'email',
                'status',
                'ativo',
                'password',
                'password_confirmation'
            ]);

            $userNew = User::create($user);

            return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'userNew' => $userNew], JsonResponse::HTTP_CREATED);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function changeAvatarAction(Request $request) {

        $user = User::find($request->user_id);

        if($user->avatar) {
            unlink(public_path('upload/'.$user->getRawOriginal('avatar')));
        }

        $image = $request->file('avatar');

        $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();

        $image->move('upload/'.$user->tenant->cnpj_cpf_formatado, $imageName);

        User::where('id', $request->user_id)->update([
            'avatar' => $user->tenant->cnpj_cpf_formatado.'/'.$imageName
        ]);

        return response()->json(['message' => 'Avatar do usuário cadastrado com sucesso!'], JsonResponse::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (!isAdmin::check()) {
            return response()->json(['message' => 'Você não é um administrador'], JsonResponse::HTTP_FORBIDDEN);
        }

        $dados = $request->only([
            'name',
            'email',
            'status',
            'ativo',
        ]);

        $user->update($dados);

        return response()->json(['message' => 'Usuário alterado com sucesso!'], JsonResponse::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!isAdmin::check()) {
            return response()->json(['message' => 'Você não é um administrador'], JsonResponse::HTTP_FORBIDDEN);
        }

        if($user->avatar) {
            unlink(public_path('upload/'.$user->getRawOriginal('avatar')));
        }

        $dados['ativo'] = false;
        $dados['avatar'] = null;
        $user->update($dados);

        return $user;

    }

}
