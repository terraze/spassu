<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro_Assunto;

class LivroAssuntoSeeder extends Seeder
{
    /**
     * Popular a tabela com dados iniciais
     */
    public function run(): void
    {
        // Assunto: "Tecnologia" (CodAs: 1)
        // ----------------------------------
        Livro_Assunto::create([
            'CodL' => 5,  // "Livro de Tecnologia"
            'CodAs' => 1,
        ]);                

        // Assunto: "Saúde" (CodAs: 2)
        // ----------------------------------
        Livro_Assunto::create([
            'CodL' => 7,  // "Livro de Saúde"
            'CodAs' => 2,
        ]);

        // Assuntos: "Tecnologia" e "Saúde" (CodAs: 1 e 2)
        // ----------------------------------
        Livro_Assunto::create([
            'CodL' => 4,  // "Um livro qualquer"
            'CodAs' => 1,
        ]);
        Livro_Assunto::create([
            'CodL' => 4,  // "Um livro qualquer"
            'CodAs' => 2,
        ]);

        // Assunto: "Economia" (CodAs: 3)
        // ----------------------------------
        Livro_Assunto::create([
            'CodL' => 6,  // "Livro de Economia"
            'CodAs' => 3,
        ]);
        Livro_Assunto::create([
            'CodL' => 1,  // "Todo ano tem um" 1ª edição
            'CodAs' => 3,
        ]);
        Livro_Assunto::create([
            'CodL' => 2,  // "Todo ano tem um" 2ª edição
            'CodAs' => 3,
        ]);
        Livro_Assunto::create([
            'CodL' => 3,  // "Todo ano tem um" 1ª edição
            'CodAs' => 3,
        ]);        
    }
}
