<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assunto;
class AssuntoSeeder extends Seeder
{
    /**
     * Popular a tabela com dados iniciais
     */
    public function run(): void
    {
        Assunto::create([
            'Descricao' => 'Tecnologia',
        ]);
        Assunto::create([
            'Descricao' => 'Saúde',
        ]);
        Assunto::create([
            'Descricao' => 'Economia',
        ]);
    }
}
