<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Http\Requests\StoreProcessoRequest;
use App\Http\Requests\UpdateProcessoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProcessoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Processo::with(['cliente', 'user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcessoRequest $request)
    {
        try {
            $processo = $request->only([
                'cliente_id',
                'user_id',
                'numero',
                'titulo',
                'data', // obrigatório
                'prazo',
                //'concluido',
            ]);

            // 'prazo', se não vier somar 30 dias da data
            if (!isset($processo['prazo'])) {
                $processo['prazo'] = date('Y-m-d', strtotime($processo['data'] . ' +30 days'));
            }

            Processo::create($processo);

            return response()->json(['message' => 'Processo cadastrado com sucesso!'], JsonResponse::HTTP_CREATED);

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
    public function show(Processo $processo)
    {
        // Carregar as relações especificadas junto com o modelo Processo
        $processo->load(['cliente', 'user', 'movimentos' => function($query) {
            $query->orderBy('data', 'desc');
        }, 'tenant']);

        // Retornar o recurso Processo como uma resposta JSON
        return response()->json($processo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessoRequest $request, Processo $processo)
    {
        $dados = $request->only([
            'cliente_id',
            'user_id',
            'numero',
            'titulo',
            'data', // obrigatório
            'prazo',
            //'concluido',
        ]);

        $processo->update($dados);

        return response()->json(['message' => 'Processo atualizado com sucesso!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Processo $processo)
    {
        // Verifica se o processo possui registros relacionados em ProcessoMovimento
        if ($processo->movimentos()->exists()) {
            return response()->json([
                'message' => 'Não é possível excluir o processo, pois existem movimentos relacionados.'
            ], JsonResponse::HTTP_FORBIDDEN);
        }

        // Se não houver registros relacionados, o processo pode ser excluído
        return $processo->delete();

        return response()->json(['message' => 'Processo deletado com sucesso!'], JsonResponse::HTTP_CREATED);
    }
}
