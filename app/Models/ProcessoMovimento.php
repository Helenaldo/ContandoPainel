<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoMovimento extends Model
{
    use HasFactory, TenantTable;

    protected $guarded = ['id'];
    protected $table = 'processo_movimentos';

    // Vários Movimentos tem um usuário
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function processo() {
        return $this->belongsTo(Processo::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
}
