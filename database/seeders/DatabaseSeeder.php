<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executar as seeders
     */
    public function run(): void
    {
        $this->call([
            AssuntoSeeder::class,
            AutorSeeder::class,
            LivroSeeder::class,
            LivroAssuntoSeeder::class,
            LivroAutorSeeder::class,
        ]);
    }
}
