<?php

namespace App\Http\Controllers;

use App\Models\ProcessoMovimento;
use App\Http\Requests\StoreProcessoMovimentoRequest;
use App\Http\Requests\UpdateProcessoMovimentoRequest;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

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
                'descricao'
            ]);

            $cliente = Cliente::find($request->cliente_id)->load('tenant');

            if($request->hasFile('anexo')) {
                $nameFile = Str::uuid().'.pdf';
                $caminhoFile = 'upload/'.$cliente->tenant->cnpj_cpf_formatado.'/'.$cliente->cpf_cnpj_formatado;
                $caminhoCompleto = $caminhoFile.'/'.$nameFile;

                $request->file('anexo')->move($caminhoFile, $nameFile);

                $processoMovimento['anexo'] = $caminhoCompleto;
            }

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
    public function show(ProcessoMovimento $movimento)
    {
        // $processoMovimento = ProcessoMovimento::find('15');
        // dd($processoMovimento);
        $movimento->load(['cliente', 'user', 'processo']);
        return response()->json($movimento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessoMovimentoRequest $request, ProcessoMovimento $movimento)
    {

        try {
            $dados = $request->only([
                'cliente_id',
                'user_id',
                'processo_id',
                'data',
                'descricao'
            ]);
            $cliente = Cliente::find($request->cliente_id)->load('tenant');

            if($request->hasFile('anexo')) {
                $nameFile = Str::uuid().'.pdf';
                $caminhoFile = 'upload/'.$cliente->tenant->cnpj_cpf_formatado.'/'.$cliente->cpf_cnpj_formatado;
                $caminhoCompleto = $caminhoFile.'/'.$nameFile;

                $request->file('anexo')->move($caminhoFile, $nameFile);

                $dados['anexo'] = $caminhoCompleto;
                unlink(public_path($movimento->anexo));
            }
            $movimento->update($dados);

            return response()->json(['message' => 'Movimento atualizado com sucesso!'], JsonResponse::HTTP_CREATED);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcessoMovimento $movimento)
    {
        //dd(public_path($movimento->getRawOriginal('anexo')), File::exists(public_path($movimento->getRawOriginal('anexo'))));

        if($movimento->getRawOriginal('anexo') && File::exists(public_path($movimento->getRawOriginal('anexo')))) {
            unlink(public_path($movimento->getRawOriginal('anexo')));
        }

        $movimento->delete();
    }
}
