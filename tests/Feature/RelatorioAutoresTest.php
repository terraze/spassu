<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class RelatorioAutoresTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Testa se a view retorna os dados corretamente
     */
    public function test_view_retorna_dados_corretos(): void
    {
        $results = DB::table('autor_report_view')->get();
        
        // Deve retornar 3 autores com base no seed
        $this->assertEquals(3, $results->count());

        // Testa dados do autor com mais livros (Economista)
        $economista = $results->firstWhere('Nome', 'Economista');
        $this->assertEquals(2, $economista->TotalLivros);
        $this->assertEquals(120.00, (float)$economista->PrecoMedio);
        $this->assertEquals('Todo ano tem um', $economista->TituloMaisBarato);
        $this->assertEquals(100.00, (float)$economista->MaisBarato);
        $this->assertEquals('Livro de Economia', $economista->TituloMaisCaro);
        $this->assertEquals(150.00, (float)$economista->MaisCaro);
        $this->assertEquals(0, $economista->TotalColaboradores);
        $this->assertEquals(1, $economista->TotalAssuntos);
        $this->assertEquals('Livro de Economia (2022)', $economista->PrimeiroLivro);

        // Testa dados do autor com colaborações (Médico)
        $medico = $results->firstWhere('Nome', 'Médico');
        $this->assertEquals(3, $medico->TotalLivros);
        $this->assertEquals(165.00, (float)$medico->PrecoMedio);
        $this->assertEquals('Livro de Saúde e Tecnologia', $medico->TituloMaisCaro);
        $this->assertEquals(300.00, (float)$medico->MaisCaro);
        $this->assertEquals('Um livro qualquer', $medico->TituloMaisBarato);
        $this->assertEquals(40.00, (float)$medico->MaisBarato);
        $this->assertEquals(1, $medico->TotalColaboradores);
        $this->assertEquals(2, $medico->TotalAssuntos);
        $this->assertEquals('Livro de Saúde e Tecnologia (2020)', $medico->PrimeiroLivro);

        // Testa dados do autor com menos livros (Programador)
        $programador = $results->firstWhere('Nome', 'Programador');
        $this->assertEquals(2, $programador->TotalLivros);
        $this->assertEquals(250.00, (float)$programador->PrecoMedio);
        $this->assertEquals('Livro de Saúde e Tecnologia', $programador->TituloMaisCaro);
        $this->assertEquals(300.00, (float)$programador->MaisCaro);
        $this->assertEquals('Livro de Tecnologia', $programador->TituloMaisBarato);
        $this->assertEquals(150.00, (float)$programador->MaisBarato);
        $this->assertEquals(1, $programador->TotalColaboradores);
        $this->assertEquals(2, $programador->TotalAssuntos);
        $this->assertEquals('Livro de Saúde e Tecnologia (2020)', $programador->PrimeiroLivro);    
    }

    /**
     * Testa se a página web carrega
     */
    public function test_pagina_web_carrega_dados_corretos(): void
    {
        $response = $this->get(route('relatorios.autores'));
        $response->assertStatus(200)
                 ->assertViewHas('autores')
                 ->assertSee('Economista')
                 ->assertSee('Médico')
                 ->assertSee('Programador');
    }
}
