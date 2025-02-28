<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Roda as migrações
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS assunto_report_view");
        
        DB::statement("
            CREATE VIEW assunto_report_view AS
            SELECT 
                a.Descricao as Assunto,
                l.Editora,
                COUNT(DISTINCT l.Titulo) as TotalLivros,
                COUNT(l.CodL) as TotalEdicoes            
            FROM Assunto a
            LEFT JOIN Livro_Assunto la ON a.CodAs = la.CodAs
            LEFT JOIN Livro l ON la.CodL = l.CodL
            GROUP BY a.Descricao, l.Editora
            ORDER BY a.Descricao, l.Editora
        ");
    }

    /**
     * Reverte as migrações
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS assunto_report_view");
    }
};
