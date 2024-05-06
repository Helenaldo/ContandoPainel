<?php

namespace App\Http\Requests;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class EmailVerificationRequest extends FormRequest
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
            'contrato' => 'string|required|exists:tenants,contrato',
            'user_name' => 'string|required|max:50',

            'senha_provisoria' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Encontrar o tenant_id pelo contrato
                    $tenant = Tenant::where('contrato', $this->contrato)->first();
                    // if (!$tenant) {
                    //     $fail('Nenhum tenant encontrado com este contrato.');
                    //     return;
                    // }

                    // Encontrar o usuário associado ao tenant_id
                    $user = User::where('tenant_id', $tenant->id)->first();
                    if (!$user || !Hash::check($value, $user->password)) {
                        $fail('A senha provisória não corresponde à senha atual do usuário.');
                    }
                }
            ],

            'password' => 'string|required|min:6|confirmed'
        ];
    }
}
