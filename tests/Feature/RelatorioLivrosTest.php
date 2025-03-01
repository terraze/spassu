<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class RelatorioLivrosTest extends TestCase
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
        $results = DB::table('livro_report_view')->get();
        
        // Deve retornar 6 livros (não 8, pois alguns são edições do mesmo livro)
        $this->assertEquals(6, $results->count());

        // Testa livro com múltiplas edições (deve retornar apenas a última)
        $livroAnual = $results->firstWhere('Titulo', 'Todo ano tem um');
        $this->assertEquals(3, $livroAnual->EdicaoAtual); // Última edição
        $this->assertEquals(3, $livroAnual->TotalEdicoes); // Total de edições
        $this->assertEquals(120.00, $livroAnual->Preco); // Preço da última edição
        $this->assertEquals(2025, $livroAnual->AnoPublicacao); // Ano da última edição
        $this->assertEquals('Economista', $livroAnual->Autores); // Autor

        // Testa livro com múltiplos autores
        $livroMultiAutor = $results->firstWhere('Titulo', 'Livro de Saúde e Tecnologia');
        $this->assertEquals(1, $livroMultiAutor->EdicaoAtual);
        $this->assertEquals(1, $livroMultiAutor->TotalEdicoes);
        $this->assertEquals('MedTechBooks', $livroMultiAutor->Editora);
        $this->assertEquals(300.00, $livroMultiAutor->Preco);
        $this->assertEquals(2020, $livroMultiAutor->AnoPublicacao);
        $this->assertEquals('Médico, Programador', $livroMultiAutor->Autores); // Ordenado alfabeticamente

        // Testa livro com apenas uma edição
        $livroUnico = $results->firstWhere('Titulo', 'Livro de Tecnologia');
        $this->assertEquals(1, $livroUnico->EdicaoAtual);
        $this->assertEquals(1, $livroUnico->TotalEdicoes);
        $this->assertEquals('Programador', $livroUnico->Autores);

        // Testa livro que começa na segunda edição
        $livroSegundaEdicao = $results->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals(2, $livroSegundaEdicao->EdicaoAtual);
        $this->assertEquals(1, $livroSegundaEdicao->TotalEdicoes);
        $this->assertEquals(40.00, $livroSegundaEdicao->Preco);
        $this->assertEquals('Médico', $livroSegundaEdicao->Autores);

        // Verifica se os resultados estão ordenados por título
        $titulos = $results->pluck('Titulo')->toArray();
        $titulosOrdenados = [
            'Livro de Economia',
            'Livro de Saúde',
            'Livro de Saúde e Tecnologia',
            'Livro de Tecnologia',
            'Todo ano tem um',
            'Um livro qualquer'
        ];
        $this->assertEquals($titulosOrdenados, $titulos);
            
    }

    /**
     * Testa se a página web carrega
     */
    public function test_pagina_web_carrega_dados_corretos(): void
    {
        $response = $this->get(route('relatorios.livros'));
        $response->assertStatus(200)
                 ->assertViewHas('livros')
                 ->assertSee('Todo ano tem um')
                 ->assertSee('Livro de Saúde e Tecnologia');
    }
}
