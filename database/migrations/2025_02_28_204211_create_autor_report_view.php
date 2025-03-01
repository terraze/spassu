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
        DB::statement("DROP VIEW IF EXISTS autor_report_view");
        
        DB::statement("
            CREATE VIEW autor_report_view AS

                WITH PrecosLivros AS (
                    SELECT 
                        a.CodAu,
                        a.Nome,
                        MIN(l.Preco) as MaisBarato,
                        MAX(l.Preco) as MaisCaro,
                        ROUND(AVG(l.Preco), 2) as PrecoMedio,
                        COUNT(DISTINCT l.Titulo) as TotalLivros,
                        COUNT(DISTINCT las.CodAs) as TotalAssuntos
                    FROM Autor a
                    LEFT JOIN Livro_Autor la ON a.CodAu = la.CodAu
                    LEFT JOIN Livro l ON la.CodL = l.CodL
                    LEFT JOIN Livro_Assunto las ON l.CodL = las.CodL
                    GROUP BY a.CodAu, a.Nome
                )
                SELECT DISTINCT
                    p.*,
                    (
                        SELECT COUNT(DISTINCT la.CodAu)
                        FROM Livro_Autor la
                        WHERE la.CodL IN (
                            SELECT CodL FROM Livro_Autor WHERE CodAu = p.CodAu
                        )
                        AND la.CodAu != p.CodAu
                    ) as TotalColaboradores,
                    (
                        SELECT l.Titulo
                        FROM Livro l
                        JOIN Livro_Autor la ON l.CodL = la.CodL
                        WHERE l.Preco = p.MaisBarato AND la.CodAu = p.CodAu
                        LIMIT 1
                    ) as TituloMaisBarato,
                    (
                        SELECT l.Titulo
                        FROM Livro l
                        JOIN Livro_Autor la ON l.CodL = la.CodL
                        WHERE l.Preco = p.MaisCaro AND la.CodAu = p.CodAu
                        LIMIT 1
                    ) as TituloMaisCaro,
                    (
                        SELECT CONCAT(l.Titulo, ' (', l.AnoPublicacao, ')')
                        FROM Livro l
                        JOIN Livro_Autor la ON l.CodL = la.CodL
                        JOIN Autor a ON la.CodAu = a.CodAu
                        WHERE a.Nome = p.Nome
                        ORDER BY l.AnoPublicacao ASC
                        LIMIT 1
                    ) as PrimeiroLivro
                FROM PrecosLivros p
                ORDER BY p.Nome;
        ");
    }

    /**
     * Reverte as migrações
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS autor_report_view");
    }
}; 