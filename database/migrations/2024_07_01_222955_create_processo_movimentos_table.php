<?php

use App\Models\Cliente;
use App\Models\Processo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tenant;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processo_movimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tenant::class)->index();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Processo::class);
            $table->foreignIdFor(Cliente::class);
            $table->date('data');
            $table->text('descricao');
            $table->string('anexo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processo_movimentos');
    }
};
