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
        // Remove a view livro_report_view se existir
        DB::statement("DROP VIEW IF EXISTS livro_report_view");
        
        // Cria a view livro_report_view
        DB::statement("
            CREATE VIEW livro_report_view AS

            WITH UltimaEdicao AS (
                SELECT 
                    l.Titulo,
                    MAX(l.Edicao) as UltimaEdicao
                FROM Livro l
                GROUP BY l.Titulo
            )

            SELECT 
                l.CodL,
                l.Titulo,
                l.Editora,
                l.Edicao AS EdicaoAtual,
                (SELECT COUNT(*) FROM Livro l2 WHERE l2.Titulo = l.Titulo) as TotalEdicoes,
                l.Preco,
                l.AnoPublicacao,
                GROUP_CONCAT(DISTINCT a.Descricao ORDER BY a.Descricao SEPARATOR ', ') as Assuntos,
                GROUP_CONCAT(DISTINCT au.Nome ORDER BY au.Nome SEPARATOR ', ') as Autores

            FROM Livro l

            INNER JOIN UltimaEdicao ue ON l.Titulo = ue.Titulo AND l.Edicao = ue.UltimaEdicao
            LEFT JOIN Livro_Assunto la ON l.CodL = la.CodL
            LEFT JOIN Assunto a ON la.CodAs = a.CodAs
            LEFT JOIN Livro_Autor lau ON l.CodL = lau.CodL
            LEFT JOIN Autor au ON lau.CodAu = au.CodAu

            GROUP BY 
                l.CodL,
                l.Titulo,
                l.Editora,
                l.Preco,
                l.AnoPublicacao

            ORDER BY l.Titulo
        ");
    }

    /**
     * Reverte as migrações
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS livro_report_view");
    }
};
