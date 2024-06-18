<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TributacaoCliente extends Model
{
    use HasFactory, TenantTable;

    protected $guarded = ['id'];
    protected $table = 'tributacao_clientes';

        // Vários clientes tem várias tributações
        public function cliente() {
            return $this->belongsTo(Cliente::class);
        }

}
