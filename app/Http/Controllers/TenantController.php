<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\Tenant;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Http\Resources\TenantResource;
use App\Models\User;
use App\Services\ContractIdentifierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    protected $identifierService;

    public function __construct(ContractIdentifierService $identifierService)
    {
        $this->identifierService = $identifierService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tenant::with('users')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantRequest $request)
    {
        $tenant = $request->only([
            'tipo_identificacao', // CNPJ ou CPF
            'cnpj_cpf',
            'nome',
            'email',
            'cep',
            'logradouro',
            'numero',
            'bairro',
            'complemento',
            'telefone',
            'cidade_id',
        ]);
        // Converter email para minúsculas
        $tenant['email'] = Str::lower($tenant['email']);

        // Gerando um contrato para o Tenant
        $tenant['contrato'] = $this->identifierService->generateUniqueIdentifier();

        // Salvando na tabela Tenant
        $createdTenant = Tenant::create($tenant);

        $passwordTemp = Str::random(6);
        // Salvando o primeiro usuário do Tenant
        $user = [
            'tenant_id' => $createdTenant->id, // Utilizando o ID do Tenant recém-criado
            'name' => $tenant['nome'],
            'email' => $tenant['email'], // O email já está em minúsculas
            'password' => Hash::make($passwordTemp), // Senha provisória 'password'
        ];
        $newUser = User::create($user);

        // Dispara email de boas vindas ao usuário
        UserRegistered::dispatch($createdTenant, $newUser, $passwordTemp);

        return response()->json(['message' => 'Empresa cadastrada com sucesso!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return new TenantResource($tenant->load('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        $tenantId = $request->query('id');
        $tenant = Tenant::find($tenantId);

        if($tenant) {
            $data = $request->only([
                'nome',
                'email',
                'cep',
                'logradouro',
                'numero',
                'bairro',
                'complemento',
                'cidade_id',
                'telefone',
                'data_saida',
            ]);
            $tenant->fill($data)->save();

            return response()->json(['message' => 'Empresa alterada com sucesso!']);


        }
        //return redirect()->route('tenant.listar')->with('error', 'Cliente não alterado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->users()->delete();
        $tenant->delete();
        return response()->json(['message' => 'Empresa deletada com sucesso!']);
    }
}
