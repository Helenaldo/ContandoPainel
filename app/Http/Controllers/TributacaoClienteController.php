<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TributacaoCliente;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreTributacaoClienteRequest;
use App\Http\Requests\UpdateTributacaoClienteRequest;
use Illuminate\Validation\ValidationException;

class TributacaoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TributacaoCliente::with('cliente')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTributacaoClienteRequest $request)
    {
        try {
            $tributacao = $request->only([
                'tipo', // Presumido, Simples Nacional, Real Trimestral, Real Anual, Isenta, Imune
                'data',
                'cliente_id'
            ]);

            TributacaoCliente::create($tributacao);

            return response()->json(['message' => 'Tributação cadastrada com sucesso!'], JsonResponse::HTTP_CREATED);

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
    public function show(TributacaoCliente $tributacaoCliente)
    {
        // Carregar o relacionamento 'cliente' juntamente com a consulta
        $tributacaoCliente->load('cliente');
        return response()->json($tributacaoCliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTributacaoClienteRequest $request, TributacaoCliente $tributacaoCliente)
    {
        $dados = $request->only([
            'tipo', // Presumido, Simples Nacional, Real Trimestral, Real Anual, Isenta, Imune
            'data',
        ]);

        $tributacaoCliente->update($dados);


        return response()->json(['message' => 'Tributação alterada com sucesso!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TributacaoCliente $tributacaoCliente)
    {
        return $tributacaoCliente->delete();
    }
}
