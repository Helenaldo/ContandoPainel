<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory, TenantTable;

    protected $guarded = ['id'];
    protected $table = 'contatos';

        // Vários contatos tem um cliente
        public function cliente() {
            return $this->belongsTo(Cliente::class);
        }
}
