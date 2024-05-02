<?php

namespace App\Http\Requests;

use App\Rules\CidadeExiste;
use App\Rules\CleanCepRule;
use App\Rules\CnpjValidationRule;
use App\Rules\CpfValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
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
    /**
     * When we fail validation, override our default error.
     *
     * @param ValidatorContract $validator
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $this->validator->errors();

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'errors' => $errors,
                'message' => 'The given data was invalid.',
            ], 422)
        );
    }


    public function rules(): array
    {
        return [
            'tipo_identificacao' => 'required|in:CNPJ,CPF',

            'cnpj_cpf' => [
                'required',
                'unique:tenants,cnpj_cpf',
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


            'nome' => 'required|string|max:255',
            'email' => 'required|email|lowercase|unique:users,email',
            'cep' => ['required','string', new CleanCepRule],
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'telefone' => 'required|string',
            'cidade_id' => ['required', 'integer', new CidadeExiste],
        ];
    }
}
