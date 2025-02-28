<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class LivroTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Testa se os livros são listados com sucesso
     */
    public function test_livros_listados_com_sucesso(): void
    {
        $response = $this->get('/api/livros');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        $response->assertJsonStructure([
            '*' => [
                'CodL',
                'Titulo',
                'AnoPublicacao',
                'Editora',
                'Edicao',
                'Preco'
            ]
        ]);
    }    

    /**
     * Testa se os livros são ordenados por código decrescente
     */
    public function test_livros_ordenados_por_codigo_decrescente(): void
    {
        $response = $this->get('/api/livros?ordenarCampo=CodL&ordenarDirecao=desc');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        
        $data = $response->json();
        
        $this->assertEquals(8, $data[0]['CodL']);
        $this->assertEquals(7, $data[1]['CodL']);
        $this->assertEquals(6, $data[2]['CodL']);
        $this->assertEquals(5, $data[3]['CodL']);
        $this->assertEquals(4, $data[4]['CodL']);
        $this->assertEquals(3, $data[5]['CodL']);
        $this->assertEquals(2, $data[6]['CodL']);
        $this->assertEquals(1, $data[7]['CodL']);        
    }

    /**
     * Testa se os livros são ordenados por título crescente
     */
    public function test_livros_ordenados_por_titulo_crescente(): void
    {
        $response = $this->get('/api/livros?ordenarCampo=Titulo&ordenarDirecao=asc');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        
        $data = $response->json();
        
        $this->assertEquals('Livro de Economia', $data[0]['Titulo']);
        $this->assertEquals('Livro de Saúde', $data[1]['Titulo']);
        $this->assertEquals('Livro de Saúde e Tecnologia', $data[2]['Titulo']);
        $this->assertEquals('Livro de Tecnologia', $data[3]['Titulo']);
        $this->assertEquals('Todo ano tem um', $data[4]['Titulo']);
        $this->assertEquals('Todo ano tem um', $data[5]['Titulo']); 
        $this->assertEquals('Todo ano tem um', $data[6]['Titulo']);
        $this->assertEquals('Um livro qualquer', $data[7]['Titulo']);        
    }

    /**
     * Testa se os livros são ordenados por ano crescente
     */
    public function test_livros_ordenados_por_ano_crescente(): void
    {
        $response = $this->get('/api/livros?ordenarCampo=AnoPublicacao&ordenarDirecao=asc');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        
        $data = $response->json();
        
        $this->assertEquals('2020', $data[0]['AnoPublicacao']);
        $this->assertEquals('2022', $data[1]['AnoPublicacao']);
        $this->assertEquals('2023', $data[2]['AnoPublicacao']);
        $this->assertEquals('2024', $data[3]['AnoPublicacao']);
        $this->assertEquals('2024', $data[4]['AnoPublicacao']); 
        $this->assertEquals('2025', $data[5]['AnoPublicacao']); 
        $this->assertEquals('2025', $data[6]['AnoPublicacao']); 
        $this->assertEquals('2025', $data[7]['AnoPublicacao']); 
    }

    /**
     * Testa se os livros são ordenados por edição decrescente
     */
    public function test_livros_ordenados_por_edicao_decrescente(): void
    {
        $response = $this->get('/api/livros?ordenarCampo=Edicao&ordenarDirecao=desc');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        
        $data = $response->json();
        
        $this->assertEquals(3, $data[0]['Edicao']);
        $this->assertEquals(2, $data[1]['Edicao']);
        $this->assertEquals(2, $data[2]['Edicao']);
        $this->assertEquals(1, $data[3]['Edicao']);
        $this->assertEquals(1, $data[4]['Edicao']); 
        $this->assertEquals(1, $data[5]['Edicao']); 
        $this->assertEquals(1, $data[6]['Edicao']); 
        $this->assertEquals(1, $data[7]['Edicao']); 
    }

    /**
     * Testa se os livros são ordenados por editora decrescente
     */
    public function test_livros_ordenados_por_editora_decrescente(): void
    {
        $response = $this->get('/api/livros?ordenarCampo=Editora&ordenarDirecao=desc');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        
        $data = $response->json();
        
        $this->assertEquals('MedTechBooks', $data[0]['Editora']);
        $this->assertEquals('Independente', $data[1]['Editora']);
        $this->assertEquals('Independente', $data[2]['Editora']);
        $this->assertEquals('Independente', $data[3]['Editora']);
        $this->assertEquals('Independente', $data[4]['Editora']); 
        $this->assertEquals('Editora Anual', $data[5]['Editora']); 
        $this->assertEquals('Editora Anual', $data[6]['Editora']); 
        $this->assertEquals('Editora Anual', $data[7]['Editora']); 
    }

    /**
     * Testa se os livros são ordenados por preço crescente
     */
    public function test_livros_ordenados_por_preco_crescente(): void
    {
        $response = $this->get('/api/livros?ordenarCampo=Preco&ordenarDirecao=asc');
        $response->assertStatus(200);

        $response->assertJsonCount(8);
        
        $data = $response->json();
        
        $this->assertEquals(40.00, $data[0]['Preco']);
        $this->assertEquals(100.00, $data[1]['Preco']);
        $this->assertEquals(110.00, $data[2]['Preco']);
        $this->assertEquals(120.00, $data[3]['Preco']);
        $this->assertEquals(145.00, $data[4]['Preco']); 
        $this->assertEquals(150.00, $data[5]['Preco']); 
        $this->assertEquals(150.00, $data[6]['Preco']); 
        $this->assertEquals(300.00, $data[7]['Preco']); 
    }

    /**
     * Testa se um livro é excluído com sucesso junto com suas associações
     */
    public function test_livro_excluido(): void
    {    
        $livro = \App\Models\Livro::first();

        // Garante que existem associações
        DB::table('Livro_Autor')->insert(['CodL' => $livro->CodL, 'CodAu' => 1]);
        DB::table('Livro_Assunto')->insert(['CodL' => $livro->CodL, 'CodAs' => 1]);

        $response = $this->delete("/api/livros/{$livro->CodL}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Livro excluído com sucesso'
        ]);

        // Verifica se o livro foi removido
        $this->assertDatabaseMissing('Livro', [
            'CodL' => $livro->CodL
        ]);

        // Verifica se as associações foram removidas
        $this->assertDatabaseMissing('Livro_Autor', [
            'CodL' => $livro->CodL
        ]);
        $this->assertDatabaseMissing('Livro_Assunto', [
            'CodL' => $livro->CodL
        ]);
    }

    /**
     * Testa se retorna erro ao tentar excluir livro inexistente
     */
    public function test_404_ao_excluir_livro_inexistente(): void
    {
        $response = $this->delete('/api/livros/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Livro não encontrado'
        ]);
    }    
} 