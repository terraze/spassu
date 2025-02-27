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
       Schema::create('Livro_Autor', function (Blueprint $table) {
           $table->unsignedInteger('CodL');
           $table->unsignedInteger('CodAu');
           
           $table->foreign('CodL', 'Livro_Autor_FKIndex1')
               ->references('CodL')
               ->on('Livro');
               
           $table->foreign('CodAu', 'Livro_Autor_FKIndex2')
               ->references('CodAu')
               ->on('Autor');
       });
   }

   /**
    * Reverter as migrações
    */
   public function down(): void
   {
       Schema::dropIfExists('Livro_Autor');
   }
};
