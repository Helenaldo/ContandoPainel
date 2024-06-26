<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Http\Requests\StoreContatoRequest;
use App\Http\Requests\UpdateContatoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ContatoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Contato::with('cliente')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContatoRequest $request)
    {
        try {
            $contato = $request->only([
                'nome',
                'email',
                'telefone',
                'cliente_id'
            ]);

            Contato::create($contato);

            return response()->json(['message' => 'Contato cadastrada com sucesso!'], JsonResponse::HTTP_CREATED);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contato $contatoCliente)
    {
        // Carregar o relacionamento 'cliente' juntamente com a consulta
        $contatoCliente->load('cliente');
        return response()->json($contatoCliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContatoRequest $request, Contato $contatoCliente)
    {
        $dados = $request->only([
            'nome',
            'email',
            'telefone',
        ]);

        $contatoCliente->update($dados);

        return response()->json(['message' => 'Contato atualizado com sucesso!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contato $contatoCliente)
    {
        return $contatoCliente->delete();
    }
}
