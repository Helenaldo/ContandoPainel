<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory, TenantTable;

    protected $guarded = ['id'];
    protected $table = 'processos';

    // Cliente tem várias processos
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    // Usuário tem várias processos
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function movimentos() {
        return $this->hasMany(ProcessoMovimento::class);
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }
}
