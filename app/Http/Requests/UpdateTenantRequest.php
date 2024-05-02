<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\CidadeExiste;
use App\Rules\CleanCepRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTenantRequest extends FormRequest
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

            'nome' => 'required|string|max:255',
            'email' => ['required','lowercase','email', Rule::unique(User::class)->ignore($this->user()->id)],
            'cep' => ['required','string', new CleanCepRule],
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'telefone' => 'required|string',
            'cidade_id' => ['required', 'integer', new CidadeExiste],
            'data_saida' => 'date'

        ];
    }
}
