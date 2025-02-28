<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AssuntoTest extends TestCase
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
}
