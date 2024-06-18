<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cliente::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        try {
            $cliente = $request->only([
                'tipo_identificacao', // CNPJ ou CPF
                'cpf_cnpj',
                'tipo', // Matriz ou Filial
                'nome',
                'fantasia',
                'cep',
                'logradouro',
                'numero',
                'bairro',
                'complemento',
                'cidade_id',
                'data_entrada',
                'data_saida',
            ]);

            Cliente::create($cliente);

            return response()->json(['message' => 'Cliente cadastrado com sucesso!'], JsonResponse::HTTP_CREATED);

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
    public function show(Cliente $cliente)
    {
        return $cliente;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $dados = $request->only([
            'nome',
            'fantasia',
            'cep',
            'logradouro',
            'numero',
            'bairro',
            'complemento',
            'cidade_id',
            'data_entrada',
            'data_saida',
            'tipo', // Matriz ou Filial
        ]);

        $cliente->update($dados);


        return response()->json(['message' => 'Cliente alterado com sucesso!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        return $cliente->delete();
    }
}

