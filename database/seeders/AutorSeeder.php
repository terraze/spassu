<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Autor;
class AutorSeeder extends Seeder
{
    /**
     * Popular a tabela com dados iniciais
     */
    public function run(): void
    {
        Autor::create([
            'Nome' => 'Médico',
        ]);
        Autor::create([
            'Nome' => 'Economista',
        ]);
        Autor::create([
            'Nome' => 'Programador',
        ]);
    }
}
