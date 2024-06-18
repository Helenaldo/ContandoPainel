<?php

use App\Models\Cliente;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tenant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tributacao_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tenant::class)->index();
            $table->string('tipo');
            $table->date('data');
            $table->foreignIdFor(Cliente::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tributacao_clientes');
    }
};
