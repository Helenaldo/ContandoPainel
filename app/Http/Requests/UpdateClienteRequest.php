<?php

namespace App\Http\Requests;

use App\Rules\CidadeExiste;
use App\Rules\CleanCepRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
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
