<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Roda as migrações
     */
    public function up(): void
    {
        // Índices para tabela Livro
        Schema::table('Livro', function (Blueprint $table) {
            $table->index('Titulo', 'idx_livro_titulo');
            $table->index('AnoPublicacao', 'idx_livro_ano');
            $table->index('Editora', 'idx_livro_editora');
        });

        // Índices para tabela Autor
        Schema::table('Autor', function (Blueprint $table) {
            $table->index('Nome', 'idx_autor_nome');
        });

        // Índices para tabela Assunto
        Schema::table('Assunto', function (Blueprint $table) {
            $table->index('Descricao', 'idx_assunto_descricao');
        });

        // Índices para tabela pivot Livro_Autor
        Schema::table('Livro_Autor', function (Blueprint $table) {
            $table->index('CodL', 'idx_livro_autor_livro');
            $table->index('CodAu', 'idx_livro_autor_autor');
        });

        // Índices para tabela pivot Livro_Assunto
        Schema::table('Livro_Assunto', function (Blueprint $table) {
            $table->index('CodL', 'idx_livro_assunto_livro');
            $table->index('CodAs', 'idx_livro_assunto_assunto');
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        // Remover índices da tabela Livro
        Schema::table('Livro', function (Blueprint $table) {
            $table->dropIndex('idx_livro_titulo');
            $table->dropIndex('idx_livro_ano');
            $table->dropIndex('idx_livro_editora');
        });

        // Remover índices da tabela Autor
        Schema::table('Autor', function (Blueprint $table) {
            $table->dropIndex('idx_autor_nome');
        });

        // Remover índices da tabela Assunto
        Schema::table('Assunto', function (Blueprint $table) {
            $table->dropIndex('idx_assunto_descricao');
        });

        // Remover índices da tabela pivot Livro_Autor
        Schema::table('Livro_Autor', function (Blueprint $table) {
            $table->dropIndex('idx_livro_autor_livro');
            $table->dropIndex('idx_livro_autor_autor');
        });

        // Remover índices da tabela pivot Livro_Assunto
        Schema::table('Livro_Assunto', function (Blueprint $table) {
            $table->dropIndex('idx_livro_assunto_livro');
            $table->dropIndex('idx_livro_assunto_assunto');
        });
    }
};
