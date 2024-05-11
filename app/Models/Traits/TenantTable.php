<?php

namespace App\Models\Traits;

use App\Models\Tenant;
use App\Models\Scopes\TenantScope;

trait TenantTable
{

    protected static function bootTenantTable() {
        // Adiciona o escopo de tenant para todas as consultas

        static::addGlobalScope(new TenantScope);

        if(session()->has('tenant_id') && !is_null(session()->get('tenant_id'))) {
            static::creating(function($model) {
                $model->tenant_id = session()->get('tenant_id');
            });
        }
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

}
