<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Assunto;

return new class extends Migration
{
    /**
     * Rodar as migrações
     */
    public function up(): void
    {
        Schema::create('Assunto', function (Blueprint $table) {
            $table->increments('CodAs');
            $table->string('Descricao', Assunto::MAX_DESCRICAO_LENGTH);
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        Schema::dropIfExists('Assunto');
    }
};
