<?php

use App\Models\Cliente;
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
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tenant::class)->index();
            $table->foreignIdFor(Cliente::class);
            $table->foreignIdFor(User::class);
            $table->string('numero')->nullable();
            $table->string('titulo');
            $table->string('status')->nullable(); // em andamento, atrasado, concluído
            $table->date('data')->nullable();
            $table->date('prazo')->nullable();
            $table->date('concluido')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processos');
    }
};
