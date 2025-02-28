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
        Schema::table('Livro', function (Blueprint $table) {
            $table->decimal('Preco', 10, 2);        
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        Schema::table('Livro', function (Blueprint $table) {
            $table->dropColumn('Preco');
        });
    }
};
