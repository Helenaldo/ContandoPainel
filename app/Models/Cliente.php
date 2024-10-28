<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory, TenantTable;

    protected $table = 'clientes';
    protected $guarded = ['id'];

        // vários cliente tem vários tributações
        public function tributaoes(): HasMany {
            return $this->hasMany(TributacaoCliente::class);
        }

        // Um Cliente tem vários contatos
        public function contatos(): HasMany {
            return $this->hasMany(Contato::class);
        }

        public function tenant(): BelongsTo {
            return $this->belongsTo(Tenant::class);
        }

        public function getCpfCnpjFormatadoAttribute() {
            return str_replace([
                '.', '-', '/'
            ], '', $this->cpf_cnpj);
        }
}
