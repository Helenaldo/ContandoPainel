<?php

namespace App\Models\Traits;

use App\Models\Tenant;
use App\Models\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;

trait TenantTable
{

    protected static function bootTenantTable() {
        // Adiciona o escopo de tenant para todas as consultas
        // dd(Auth::user());
        static::addGlobalScope(new TenantScope);

        static::creating(function($model) {
            if(Auth::user()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

}
