<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory, TenantTable;

    protected $table = 'clientes';
    protected $guarded = ['id'];

        // vários cliente tem vários tributações
        public function tributaoes() {
            return $this->hasMany(TributacaoCliente::class);
        }

        // Um Cliente tem vários contatos
        public function contatos() {
            return $this->hasMany(Contato::class);
        }
}
