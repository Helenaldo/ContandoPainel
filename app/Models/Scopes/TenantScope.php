<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Aplique o escopo a um determinado construtor de consultas do Eloquent.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(Auth::user()) {
            $builder->where('tenant_id', Auth::user()->tenant_id);
        }

        // if(session()->has('tenant_id') && !is_null(session()->get('tenant_id'))) {
        //     $builder->where('tenant_id', session()->get('tenant_id'));
        // }
    }
}
