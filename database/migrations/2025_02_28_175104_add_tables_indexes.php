<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Roda as migrações
     */
    public function up(): void
    {
        // Índices para tabela Livro
        Schema::table('Livro', function (Blueprint $table) {
            if (!$this->hasIndex('Livro', 'idx_livro_titulo')) {
                $table->index('Titulo', 'idx_livro_titulo');
            }
            if (!$this->hasIndex('Livro', 'idx_livro_ano')) {
                $table->index('AnoPublicacao', 'idx_livro_ano');
            }
            if (!$this->hasIndex('Livro', 'idx_livro_editora')) {
                $table->index('Editora', 'idx_livro_editora');
            }
        });

        // Índices para tabela Autor
        Schema::table('Autor', function (Blueprint $table) {
            if (!$this->hasIndex('Autor', 'idx_autor_nome')) {
                $table->index('Nome', 'idx_autor_nome');
            }
        });

        // Índices para tabela Assunto
        Schema::table('Assunto', function (Blueprint $table) {
            if (!$this->hasIndex('Assunto', 'idx_assunto_descricao')) {
                $table->index('Descricao', 'idx_assunto_descricao');
            }
        });

        // Índices para tabela pivot Livro_Autor
        Schema::table('Livro_Autor', function (Blueprint $table) {
            if (!$this->hasIndex('Livro_Autor', 'idx_livro_autor_livro')) {
                $table->index('CodL', 'idx_livro_autor_livro');
            }
            if (!$this->hasIndex('Livro_Autor', 'idx_livro_autor_autor')) {
                $table->index('CodAu', 'idx_livro_autor_autor');
            }
        });

        // Índices para tabela pivot Livro_Assunto
        Schema::table('Livro_Assunto', function (Blueprint $table) {
            if (!$this->hasIndex('Livro_Assunto', 'idx_livro_assunto_livro')) {
                $table->index('CodL', 'idx_livro_assunto_livro');
            }
            if (!$this->hasIndex('Livro_Assunto', 'idx_livro_assunto_assunto')) {
                $table->index('CodAs', 'idx_livro_assunto_assunto');
            }
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        // Não é necessário explicitamente remover os índices
        // Eles serão removidos automaticamente quando as tabelas forem removidas
    }

    // Add this helper method to check if index exists
    private function hasIndex($table, $indexName)
    {
        return Schema::hasTable($table) && 
               collect(DB::select("SHOW INDEXES FROM {$table}"))->pluck('Key_name')->contains($indexName);
    }
};
