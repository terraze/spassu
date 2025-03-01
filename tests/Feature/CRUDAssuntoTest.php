<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Assunto;

class CRUDAssuntoTest extends TestCase
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
     * Testa se os assuntos são listados com sucesso
     */
    public function test_assuntos_listados_com_sucesso(): void
    {
        $response = $this->get('/api/assuntos');
        $response->assertStatus(200);

        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'CodAs',
                'Descricao'
            ]
        ]);
    }

    /**
     * Testa se os assuntos são ordenados por código decrescente
     */
    public function test_assuntos_ordenados_por_codigo_decrescente(): void
    {
        $response = $this->get('/api/assuntos?ordenarCampo=CodAs&ordenarDirecao=desc');
        $response->assertStatus(200);

        $response->assertJsonCount(3);
        
        $data = $response->json();
        
        $this->assertEquals(3, $data[0]['CodAs']);
        $this->assertEquals(2, $data[1]['CodAs']);
        $this->assertEquals(1, $data[2]['CodAs']);
    }

    /**
     * Testa se os assuntos são ordenados por descrição crescente
     */
    public function test_assuntos_ordenados_por_descricao_crescente(): void
    {
        $response = $this->get('/api/assuntos?ordenarCampo=Descricao&ordenarDirecao=asc');
        $response->assertStatus(200);

        $response->assertJsonCount(3);
        
        $data = $response->json();
        
        $this->assertEquals('Economia', $data[0]['Descricao']);
        $this->assertEquals('Saúde', $data[1]['Descricao']);
        $this->assertEquals('Tecnologia', $data[2]['Descricao']);
    }

    /**
     * Testa se um assunto é excluído com sucesso junto com suas associações
     */
    public function test_assunto_excluido(): void
    {    
        // Busca um assunto que tenha associações com livros
        $assunto = \App\Models\Assunto::query()
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('Livro_Assunto')
                      ->whereColumn('Livro_Assunto.CodAs', 'Assunto.CodAs');
            })
            ->first();

        // Se não encontrou nenhum assunto com associações, cria um
        if (!$assunto) {
            $assunto = \App\Models\Assunto::first();
            DB::table('Livro_Assunto')->insert([
                'CodL' => 1,
                'CodAs' => $assunto->CodAs
            ]);
        }

        $response = $this->delete("/api/assuntos/{$assunto->CodAs}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Assunto excluído com sucesso'
        ]);

        // Verifica se o assunto foi removido
        $this->assertDatabaseMissing('Assunto', [
            'CodAs' => $assunto->CodAs
        ]);

        // Verifica se as associações foram removidas
        $this->assertDatabaseMissing('Livro_Assunto', [
            'CodAs' => $assunto->CodAs
        ]);
    }

    /**
     * Testa se retorna erro ao tentar excluir assunto inexistente
     */
    public function test_404_ao_excluir_assunto_inexistente(): void
    {
        $response = $this->delete('/api/assuntos/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Assunto não encontrado'
        ]);
    }

    /**
     * Testa se um assunto é criado com sucesso
     */
    public function test_assunto_criado_com_sucesso(): void
    {
        $response = $this->post('/api/assuntos', [
            'Descricao' => 'Novo Assunto'
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Assunto criado com sucesso'
        ]);

        $this->assertDatabaseHas('Assunto', [
            'Descricao' => 'Novo Assunto'
        ]);
    }

    /**
     * Testa se um assunto é atualizado com sucesso
     */
    public function test_assunto_atualizado_com_sucesso(): void
    {
        // Busca o primeiro assunto
        $assunto = \App\Models\Assunto::first();
        $codAs = $assunto->CodAs;
        
        // Tenta atualizar o assunto
        $response = $this->put("/api/assuntos/{$codAs}", [
            'Descricao' => 'Assunto Atualizado'
        ]);

        // Verifica se a resposta foi bem sucedida
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Assunto atualizado com sucesso'
        ]);

        // Verifica se o registro foi atualizado no banco de dados
        $this->assertDatabaseHas('Assunto', [
            'CodAs' => $codAs,
            'Descricao' => 'Assunto Atualizado'
        ]);        
    }

    /**
     * Testa se retorna erro ao tentar atualizar assunto inexistente
     */
    public function test_404_ao_atualizar_assunto_inexistente(): void
    {
        $response = $this->put('/api/assuntos/999', [
            'Descricao' => 'Assunto Inexistente'
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Assunto não encontrado'
        ]);
    }

    /**
     * Testa se retorna erro ao tentar criar assunto sem descrição
     */
    public function test_erro_ao_criar_assunto_sem_descricao(): void
    {
        $response = $this->post('/api/assuntos', []);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['Descricao']);
    }

    /**
     * Testa se retorna erro ao tentar criar assunto com descrição muito longa
     */
    public function test_erro_ao_criar_assunto_com_descricao_muito_longa(): void
    {
        $descricaoGrande = str_repeat('a', Assunto::MAX_DESCRICAO_LENGTH + 1);
        
        $response = $this->post('/api/assuntos', [
            'Descricao' => $descricaoGrande
        ]);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['Descricao']);
        $response->assertJson([
            'errors' => [
                'Descricao' => ['A descrição não pode ter mais que ' . Assunto::MAX_DESCRICAO_LENGTH . ' caracteres']
            ]
        ]);
    }
}
