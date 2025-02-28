<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Autor;
return new class extends Migration
{
    /**
     * Rodar as migrações
     */
    public function up(): void
    {
        Schema::create('Autor', function (Blueprint $table) {
            $table->increments('CodAu');
            $table->string('Nome', Autor::MAX_NOME_LENGTH);
        });
    }

    /**
     * Reverter as migrações
     */
    public function down(): void
    {
        Schema::dropIfExists('Autor');
    }
};
