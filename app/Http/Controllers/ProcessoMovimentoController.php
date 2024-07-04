<?php

namespace App\Http\Controllers;

use App\Models\ProcessoMovimento;
use App\Http\Requests\StoreProcessoMovimentoRequest;
use App\Http\Requests\UpdateProcessoMovimentoRequest;
use App\Models\Processo;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProcessoMovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProcessoMovimento::with(['processo' , 'cliente' , 'user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcessoMovimentoRequest $request)
    {
        try {
            $processoMovimento = $request->only([
                'cliente_id',
                'user_id',
                'processo_id',
                'data',
                'descricao',
                'anexo'
            ]);

            ProcessoMovimento::create($processoMovimento);

            return response()->json(['message' => 'Movimento cadastrado com sucesso!'], JsonResponse::HTTP_CREATED);

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
    public function show(ProcessoMovimento $processoMovimento)
    {
        $processoMovimento->load(['cliente', 'user']);
        return response()->json($processoMovimento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessoMovimentoRequest $request, ProcessoMovimento $processoMovimento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcessoMovimento $processoMovimento)
    {
        //
    }
}
