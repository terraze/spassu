<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rodar as migrações
     */
    public function up(): void
    {
        Schema::create('Livro_Assunto', function (Blueprint $table) {
            $table->unsignedInteger('CodL');
            $table->unsignedInteger('CodAs');
            
            $table->foreign('CodL', 'Livro_Assunto_FKIndex1')
                ->references('CodL')
                ->on('Livro');
                
            $table->foreign('CodAs', 'Livro_Assunto_FKIndex2')
                ->references('CodAs')
                ->on('Assunto');
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        Schema::dropIfExists('Livro_Assunto');
    }
};
