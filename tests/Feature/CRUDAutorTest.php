<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Autor;

class CRUDAutorTest extends TestCase
{
    /**
     * Reinicia banco de dados antes de executar os testes desta classe
     */
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Testa se os autores são listados com sucesso
     */
    public function test_autores_listados_com_sucesso(): void
    {
        $response = $this->get('/api/autores');
        $response->assertStatus(200);

        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'CodAu',
                'Nome',
            ]
        ]);
    }

    /**
     * Testa se os autores são ordenados por código decrescente
     */
    public function test_autores_ordenados_por_codigo_decrescente(): void
    {
        $response = $this->get('/api/autores?ordenarCampo=CodAu&ordenarDirecao=desc');
        $response->assertStatus(200);

        $response->assertJsonCount(3);
        
        $data = $response->json();
        
        $this->assertEquals(3, $data[0]['CodAu']);
        $this->assertEquals(2, $data[1]['CodAu']);
        $this->assertEquals(1, $data[2]['CodAu']);
    }

    /**
     * Testa se os autores são ordenados por nome crescente
     */
    public function test_autores_ordenados_por_nome_crescente(): void
    {
        $response = $this->get('/api/autores?ordenarCampo=Nome&ordenarDirecao=asc');
        $response->assertStatus(200);

        $response->assertJsonCount(3);
        
        $data = $response->json();
        
        $this->assertEquals('Economista', $data[0]['Nome']);
        $this->assertEquals('Médico', $data[1]['Nome']);
        $this->assertEquals('Programador', $data[2]['Nome']);
    }

    /**
     * Testa se um autor é excluído com sucesso junto com suas associações
     */
    public function test_autor_excluido(): void
    {    
        // Busca um autor que tenha associações com livros
        $autor = \App\Models\Autor::query()
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('Livro_Autor')
                      ->whereColumn('Livro_Autor.CodAu', 'Autor.CodAu');
            })
            ->first();

        // Se não encontrou nenhum autor com associações, cria um
        if (!$autor) {
            $autor = \App\Models\Autor::first();
            DB::table('Livro_Autor')->insert([
                'CodLi' => 1,
                'CodAu' => $autor->CodAu
            ]);
        }

        $response = $this->delete("/api/autores/{$autor->CodAu}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Autor excluído com sucesso'
        ]);

        // Verifica se o autor foi removido
        $this->assertDatabaseMissing('Autor', [
            'CodAu' => $autor->CodAu
        ]);

        // Verifica se as associações foram removidas
        $this->assertDatabaseMissing('Livro_Autor', [
            'CodAu' => $autor->CodAu
        ]);
    }

    /**
     * Testa se um autor é criado com sucesso
     */
    public function test_autor_criado_com_sucesso(): void
    {
        $response = $this->post('/api/autores', [
            'Nome' => 'Novo Autor'
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Autor criado com sucesso'
        ]);

        $this->assertDatabaseHas('Autor', [
            'Nome' => 'Novo Autor'
        ]);
    }

    /**
     * Testa se um autor é atualizado com sucesso
     */
    public function test_autor_atualizado_com_sucesso(): void
    {
        // Busca o primeiro autor
        $autor = \App\Models\Autor::first();
        $codAu = $autor->CodAu;
        
        // Tenta atualizar o autor
        $response = $this->put("/api/autores/{$codAu}", [
            'Nome' => 'Autor Atualizado'
        ]);

        // Verifica se a resposta foi bem sucedida
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Autor atualizado com sucesso'
        ]);

        // Verifica se o registro foi atualizado no banco
        $this->assertDatabaseHas('Autor', [
            'CodAu' => $codAu,
            'Nome' => 'Autor Atualizado'
        ]);
    }

    /**
     * Testa se retorna erro ao tentar excluir autor inexistente
     */
    public function test_404_ao_excluir_autor_inexistente(): void
    {
        $response = $this->delete('/api/autores/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Autor não encontrado'
        ]);
    }

    /**
     * Testa se retorna erro ao tentar atualizar autor inexistente
     */
    public function test_404_ao_atualizar_autor_inexistente(): void
    {
        $response = $this->put('/api/autores/999', [
            'Nome' => 'Autor Inexistente'
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Autor não encontrado'
        ]);
    }

    /**
     * Testa se retorna erro ao tentar criar autor sem nome
     */
    public function test_erro_ao_criar_autor_sem_nome(): void
    {
        $response = $this->post('/api/autores', []);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['Nome']);
    }

    /**
     * Testa se retorna erro ao tentar criar autor com nome muito longo
     */
    public function test_erro_ao_criar_autor_com_nome_muito_longo(): void
    {
        $nomeGrande = str_repeat('a', Autor::MAX_NOME_LENGTH + 1);
        
        $response = $this->post('/api/autores', [
            'Nome' => $nomeGrande
        ]);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['Nome']);
        $response->assertJson([
            'errors' => [
                'Nome' => ['O nome não pode ter mais que ' . Autor::MAX_NOME_LENGTH . ' caracteres']
            ]
        ]);
    }
}
