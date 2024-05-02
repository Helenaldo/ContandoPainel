<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;
    protected $table = 'tenants';
    protected $fillable = [
        'tipo_identificacao', // CNPJ ou CPF
        'cnpj_cpf',
        'contrato',
        'nome',
        'email',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'telefone',
        'cidade_id',
        'data_saida',
    ];

    // Vários Tenants tem uma cidade
    public function cidade(): BelongsTo {
        return $this->belongsTo(Cidade::class);
    }

    // Um Tenant tem vários Usuários
    public function users(): HasMany {
        return $this->hasMany(User::class);
    }
}








