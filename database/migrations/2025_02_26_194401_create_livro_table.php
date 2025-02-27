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
        Schema::create('Livro', function (Blueprint $table) {
            $table->increments('CodL');
            $table->string('Titulo', 40);
            $table->string('Editora', 40);
            $table->integer('Edicao');
            $table->string('AnoPublicacao', 4);
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        Schema::dropIfExists('Livro');
    }
};
