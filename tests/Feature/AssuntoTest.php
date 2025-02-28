<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AssuntoSeeder;
use Tests\TestCase;

class AssuntoTest extends TestCase
{

    /**
     * Reinicia banco de dados antes de executar os testes desta classe
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(AssuntoSeeder::class);
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
        
        // Get the response data
        $data = $response->json();
        
        // Assert the order is correct regardless of IDs
        $this->assertEquals('Economia', $data[0]['Descricao']);
        $this->assertEquals('Saúde', $data[1]['Descricao']);
        $this->assertEquals('Tecnologia', $data[2]['Descricao']);
    }
}
