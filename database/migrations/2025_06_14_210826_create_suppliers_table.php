<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['F', 'J'])->comment('F: Física, J: Jurídica');
            $table->string('nome_razao', 100);
            $table->string('cpf_cnpj', 20)->unique();
            $table->string('telefone', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};