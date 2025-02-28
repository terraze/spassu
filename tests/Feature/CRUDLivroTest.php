<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Livro;
use App\Models\Assunto;
use App\Models\Autor;

class CRUDLivroTest extends TestCase
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
                'Preco',
                'TodosAssuntos',
                'TodosAutores'
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

    /**
     * Testa a criação de um livro com sucesso
     */
    public function test_livro_criado_com_sucesso(): void
    {
        $data = [
            'Titulo' => 'Novo Livro',
            'Editora' => 'Nova Editora',
            'Edicao' => 1,
            'AnoPublicacao' => date('Y'),
            'Preco' => 99.90,
            'Autores' => [1, 2],
            'Assuntos' => [1, 2]
        ];

        $response = $this->post('/api/livros', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Livro criado com sucesso'
            ]);

        // Verifica se o livro foi criado no banco
        $this->assertDatabaseHas('Livro', [
            'Titulo' => 'Novo Livro',
            'Editora' => 'Nova Editora',
            'Edicao' => 1,
            'AnoPublicacao' => date('Y'),
            'Preco' => 99.90
        ]);

        // Pega o ID do livro criado
        $livro = \App\Models\Livro::where('Titulo', 'Novo Livro')->first();

        // Verifica as relações
        $this->assertDatabaseHas('Livro_Autor', [
            'CodL' => $livro->CodL,
            'CodAu' => 1
        ]);
        $this->assertDatabaseHas('Livro_Autor', [
            'CodL' => $livro->CodL,
            'CodAu' => 2
        ]);
        $this->assertDatabaseHas('Livro_Assunto', [
            'CodL' => $livro->CodL,
            'CodAs' => 1
        ]);
        $this->assertDatabaseHas('Livro_Assunto', [
            'CodL' => $livro->CodL,
            'CodAs' => 2
        ]);
    }

    /**
     * Testa a atualização completa de um livro com sucesso
     */
    public function test_livro_atualizado_com_sucesso(): void
    {
        $livro = \App\Models\Livro::first();

        $data = [
            'Titulo' => 'Livro Atualizado',
            'Editora' => 'Editora Atualizada',
            'Edicao' => 2,
            'AnoPublicacao' => date('Y'),
            'Preco' => 199.90,
            'Autores' => [1, 2],
            'Assuntos' => [1, 2]
        ];

        $response = $this->put("/api/livros/{$livro->CodL}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Livro atualizado com sucesso'
            ]);

        // Verifica se o livro foi atualizado
        $this->assertDatabaseHas('Livro', [
            'CodL' => $livro->CodL,
            'Titulo' => 'Livro Atualizado',
            'Editora' => 'Editora Atualizada',
            'Edicao' => 2,
            'AnoPublicacao' => date('Y'),
            'Preco' => 199.90
        ]);

        // Verifica as relações
        $this->assertDatabaseHas('Livro_Autor', [
            'CodL' => $livro->CodL,
            'CodAu' => 1
        ]);
        $this->assertDatabaseHas('Livro_Autor', [
            'CodL' => $livro->CodL,
            'CodAu' => 2
        ]);
        $this->assertDatabaseHas('Livro_Assunto', [
            'CodL' => $livro->CodL,
            'CodAs' => 1
        ]);
        $this->assertDatabaseHas('Livro_Assunto', [
            'CodL' => $livro->CodL,
            'CodAs' => 2
        ]);
    }

    /**
     * Testa erro ao tentar atualizar livro inexistente
     */
    public function test_404_ao_atualizar_livro_inexistente(): void
    {
        $data = [
            'Titulo' => 'Livro Atualizado',
            'Editora' => 'Editora Atualizada',
            'Edicao' => 2,
            'AnoPublicacao' => date('Y'),
            'Preco' => 199.90,
            'Autores' => [1],
            'Assuntos' => [1]
        ];

        $response = $this->put('/api/livros/999', $data);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Livro não encontrado'
            ]);
    }

    /**
     * Testa validação do título do livro
     */
    public function test_validacao_titulo(): void
    {
        $livro = \App\Models\Livro::first();

        // Título vazio
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => '',
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Titulo']);

        $response->assertJson([
            'errors' => [
                'Titulo' => ['O título é obrigatório']
            ]
        ]);

        // Título muito longo
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => str_repeat('a', Livro::MAX_TITULO_LENGTH + 1),
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Titulo']);

        $response->assertJson([
            'errors' => [
                'Titulo' => ['O título não pode ter mais que ' . Livro::MAX_TITULO_LENGTH . ' caracteres']
            ]
        ]);
    }

    /**
     * Testa validação da editora do livro
     */
    public function test_validacao_editora(): void
    {
        $livro = \App\Models\Livro::first();

        // Editora vazia
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => '',
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Editora']);

        // Editora muito longa
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => str_repeat('a', Livro::MAX_EDITORA_LENGTH + 1),
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Editora']);

        $response->assertJson([
            'errors' => [
                'Editora' => ['O nome da editora não pode ter mais que ' . Livro::MAX_EDITORA_LENGTH . ' caracteres']
            ]
        ]);
    }

    /**
     * Testa validação da edição do livro
     */
    public function test_validacao_edicao(): void
    {
        $livro = \App\Models\Livro::first();

        // Edição vazia
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => '',
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Edicao'])
            ->assertJson([
                'errors' => [
                    'Edicao' => ['A edição é obrigatória']
                ]
            ]);

        // Edição não numérica
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => 'abc',
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Edicao'])
            ->assertJson([
                'errors' => [
                    'Edicao' => ['A edição deve ser um número inteiro']
                ]
            ]);

        // Edição decimal
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => 1.5,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Edicao'])
            ->assertJson([
                'errors' => [
                    'Edicao' => ['A edição deve ser um número inteiro']
                ]
            ]);

        // Edição menor que 1
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => 0,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Edicao'])
            ->assertJson([
                'errors' => [
                    'Edicao' => ['A edição deve ser maior que zero']
                ]
            ]);
    }

    /**
     * Testa validação do ano de publicação do livro
     */
    public function test_validacao_ano_publicacao(): void
    {
        $livro = \App\Models\Livro::first();

        // Ano vazio
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => '',
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['AnoPublicacao'])
            ->assertJson([
                'errors' => [
                    'AnoPublicacao' => ['O ano de publicação é obrigatório']
                ]
            ]);

        // Ano não numérico
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => 'abc',
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['AnoPublicacao'])
            ->assertJson([
                'errors' => [
                    'AnoPublicacao' => ['O ano de publicação deve ser um número inteiro']
                ]
            ]);

        // Ano decimal
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => 2023.5,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['AnoPublicacao'])
            ->assertJson([
                'errors' => [
                    'AnoPublicacao' => ['O ano de publicação deve ser um número inteiro']
                ]
            ]);

        // Ano menor que 1900
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => Livro::MIN_ANO_PUBLICACAO - 1,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['AnoPublicacao'])
            ->assertJson([
                'errors' => [
                    'AnoPublicacao' => ['O ano de publicação deve ser maior ou igual a ' . Livro::MIN_ANO_PUBLICACAO]
                ]
            ]);

        // Ano maior que o atual
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => date('Y') + 1,
            'Preco' => $livro->Preco
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['AnoPublicacao'])
            ->assertJson([
                'errors' => [
                    'AnoPublicacao' => ['O ano de publicação não pode ser maior que o ano atual']
                ]
            ]);
    }

    /**
     * Testa validação do preço do livro
     */
    public function test_validacao_preco(): void
    {
        $livro = \App\Models\Livro::first();

        // Preço vazio
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => ''
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Preco'])
            ->assertJson([
                'errors' => [
                    'Preco' => ['O preço é obrigatório']
                ]
            ]);

        // Preço não numérico
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => 'abc'
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Preco'])
            ->assertJson([
                'errors' => [
                    'Preco' => ['O preço deve ser um número']
                ]
            ]);

        // Preço com mais de 2 casas decimais
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => 10.999
        ]);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['Preco'])
            ->assertJson([
                'errors' => [
                    'Preco' => ['O preço não pode ter mais que 2 casas decimais']
                ]
            ]);

        // Preço negativo
        $response = $this->put("/api/livros/{$livro->CodL}", [
            'Titulo' => $livro->Titulo,
            'Editora' => $livro->Editora,
            'Edicao' => $livro->Edicao,
            'AnoPublicacao' => $livro->AnoPublicacao,
            'Preco' => -1
        ]);

        $response->assertStatus(400)    
            ->assertJsonValidationErrors(['Preco'])
            ->assertJson([
                'errors' => [
                    'Preco' => ['O preço deve ser maior ou igual a zero']
                ]
            ]);
    }

    /**
     * Testa a agregação de assuntos de um livro
     */
    public function test_agregar_assuntos(): void
    {
        // Pega o livro "Um livro qualquer"
        $livro = Livro::where('Titulo', 'Um livro qualquer')->first();
        
        // Verifica assuntos iniciais
        $response = $this->getJson('/api/livros');
        $livroResponse = collect($response->json())->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals('Saúde, Tecnologia', $livroResponse['TodosAssuntos']);
        
        // Adiciona novo assunto (Economia)
        $livro->assuntos()->attach(3);
        
        // Verifica se Economia foi adicionado
        $response = $this->getJson('/api/livros');
        $livroResponse = collect($response->json())->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals('Economia, Saúde, Tecnologia', $livroResponse['TodosAssuntos']);
        
        // Remove todos os assuntos
        $livro->assuntos()->detach();
        
        // Verifica se ficou vazio
        $response = $this->getJson('/api/livros');
        $livroResponse = collect($response->json())->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals('-', $livroResponse['TodosAssuntos']);
    }

    /**
     * Testa a agregação de autores de um livro
     */
    public function test_agregar_autores(): void
    {
        // Pega o livro "Um livro qualquer"
        $livro = Livro::where('Titulo', 'Um livro qualquer')->first();
        
        // Verifica autor inicial
        $response = $this->getJson('/api/livros');
        $livroResponse = collect($response->json())->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals('Médico', $livroResponse['TodosAutores']);
        
        // Adiciona novo autor (Economista)
        $livro->autores()->attach(2);
        
        // Verifica se Economista foi adicionado
        $response = $this->getJson('/api/livros');
        $livroResponse = collect($response->json())->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals('Economista, Médico', $livroResponse['TodosAutores']);
        
        // Remove todos os autores
        $livro->autores()->detach();
        
        // Verifica se ficou vazio
        $response = $this->getJson('/api/livros');
        $livroResponse = collect($response->json())->firstWhere('Titulo', 'Um livro qualquer');
        $this->assertEquals('-', $livroResponse['TodosAutores']);
    }
} 