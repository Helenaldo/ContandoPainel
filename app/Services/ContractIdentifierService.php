<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Str;

class ContractIdentifierService
{
    /**
     * Gera um identificador de contrato único.
     *
     * @return string
     */
    public function generateUniqueIdentifier(): string
    {
        do {
            $identifier = Str::upper(Str::random(6));
        } while (Tenant::where('contrato', $identifier)->exists());

        return $identifier;
    }
}
