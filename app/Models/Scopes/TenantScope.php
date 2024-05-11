<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Aplique o escopo a um determinado construtor de consultas do Eloquent.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(session()->has('tenant_id') && !is_null(session()->get('tenant_id'))) {
            $builder->where('tenant_id', session()->get('tenant_id'));
        }
    }
}
