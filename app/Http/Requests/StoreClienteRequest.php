<?php

namespace App\Http\Requests;

use App\Rules\CidadeExiste;
use App\Rules\CleanCepRule;
use App\Rules\CnpjValidationRule;
use App\Rules\CpfValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        // dd($this->all());
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_identificacao' => 'required|string|in:CNPJ,CPF',

            'cpf_cnpj' => [
                'required',
                'unique:clientes,cpf_cnpj',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->input('tipo_identificacao') === 'CPF') {
                        $rule = new CpfValidationRule;
                        if ($rule->passes($attribute, $value, $fail)) {
                            return;
                        }
                    } elseif ($this->input('tipo_identificacao') === 'CNPJ') {
                        $rule = new CnpjValidationRule;
                        if ($rule->passes($attribute, $value, $fail)) {
                            return;
                        }
                    }

                    $fail("O campo $attribute não pôde ser validado.");
                },
            ],

            'tipo' => 'in:Matriz,Filial',
            'nome' => 'required|string|max:255',
            'fantasia' => 'string|max:255',
            'cep' => ['string', new CleanCepRule],
            'logradouro' => 'string|max:255',
            'numero' => 'string|max:10',
            'bairro' => 'string|max:255',
            'complemento' => 'nullable|string|max:255',
            'cidade_id' => ['required', 'integer', new CidadeExiste],
            'data_entrada' => 'date|nullable',
            'data_saida' =>'date|nullable',

        ];
    }
}






