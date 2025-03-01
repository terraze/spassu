<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivroSeeder extends Seeder
{
    /**
     * Popular a tabela com dados iniciais
     */
    public function run(): void
    {
        // Livros com multiplas edições
        Livro::create([
            'Titulo' => 'Todo ano tem um',
            'Editora' => 'Editora Anual',
            'Edicao' => 1,
            'AnoPublicacao' => '2023',
            'Preco' => 100.00,
        ]);
        Livro::create([
            'Titulo' => 'Todo ano tem um',
            'Editora' => 'Editora Anual',
            'Edicao' => 2,
            'AnoPublicacao' => '2024',
            'Preco' => 110.00,
        ]);
        Livro::create([
            'Titulo' => 'Todo ano tem um',
            'Editora' => 'Editora Anual',
            'Edicao' => 3,
            'AnoPublicacao' => '2025',
            'Preco' => 120.00,
        ]);

        // Livro com apenas segunda edição
        Livro::create([
            'Titulo' => 'Um livro qualquer',
            'Editora' => 'Independente',
            'Edicao' => 2,
            'AnoPublicacao' => '2025',
            'Preco' => 40.00,
        ]);

        // Livros para cada categoria e apenas uma edição
        Livro::create([
            'Titulo' => 'Livro de Tecnologia',
            'Editora' => 'Independente',
            'Edicao' => 1,
            'AnoPublicacao' => '2025',
            'Preco' => 150.00,
        ]);        
        Livro::create([
            'Titulo' => 'Livro de Economia',
            'Editora' => 'Independente',
            'Edicao' => 1,
            'AnoPublicacao' => '2022',
            'Preco' => 150.00,
        ]);
        Livro::create([
            'Titulo' => 'Livro de Saúde',
            'Editora' => 'Independente',
            'Edicao' => 1,
            'AnoPublicacao' => '2024',
            'Preco' => 145.00,
        ]);

        // Livro multi-autor
        Livro::create([
            'Titulo' => 'Livro de Saúde e Tecnologia',
            'Editora' => 'MedTechBooks',
            'Edicao' => 1,
            'AnoPublicacao' => '2020',
            'Preco' => 300.00,
        ]);
    }
}
