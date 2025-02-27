<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro_Autor;

class LivroAutorSeeder extends Seeder
{
    /**
     * Popular a tabela com dados iniciais
     */
    public function run(): void
    {
        // Autor: "Médico" (CodAs: 1)
        // ----------------------------------
        Livro_Autor::create([
            'CodL' => 4,  // "Um livro qualquer"
            'CodAu' => 1,
        ]);
        Livro_Autor::create([
            'CodL' => 7,  // "Livro de Saúde"
            'CodAu' => 1,
        ]);
        Livro_Autor::create([
            'CodL' => 8,  // "Livro de Saúde e Tecnologia"
            'CodAu' => 1,
        ]);


        // Autor: "Economista" (CodAs: 2)
        // ----------------------------------
        Livro_Autor::create([
            'CodL' => 1,  // "Todo ano tem um"
            'CodAu' => 2,
        ]);
        Livro_Autor::create([
            'CodL' => 2,  // "Todo ano tem um"
            'CodAu' => 2,
        ]);
        Livro_Autor::create([
            'CodL' => 3,  // "Todo ano tem um"
            'CodAu' => 2,
        ]);
        Livro_Autor::create([
            'CodL' => 6,  // "Livro de Economia"
            'CodAu' => 2,
        ]);             

        // Autor: "Programador" (CodAs: 3)
        // ----------------------------------        
        Livro_Autor::create([
            'CodL' => 5,  // "Livro de Tecnologia"
            'CodAu' => 3,
        ]);
        Livro_Autor::create([
            'CodL' => 8,  // "Livro de Saúde e Tecnologia"
            'CodAu' => 3,
        ]);
    }
}
