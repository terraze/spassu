<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class RelatorioAssuntosTest extends TestCase
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
        $results = DB::table('assunto_report_view')->get();
        
        // Deve retornar ao menos um registro com base no seed
        $this->assertEquals(6, $results->count());

        // Testa se os resultados estão ordenados por assunto e editora
        $assuntosEditoras = $results->map(function($item) {
            return [
                'Assunto' => $item->Assunto,
                'Editora' => $item->Editora,
                'TotalLivros' => $item->TotalLivros,
                'TotalEdicoes' => $item->TotalEdicoes
            ];
        })->toArray();

        $esperado = [
            [
                'Assunto' => 'Economia',
                'Editora' => 'Editora Anual',
                'TotalLivros' => 1,
                'TotalEdicoes' => 3
            ],
            [
                'Assunto' => 'Economia',
                'Editora' => 'Independente',
                'TotalLivros' => 1,
                'TotalEdicoes' => 1
            ],
            [
                'Assunto' => 'Saúde',
                'Editora' => 'Independente',
                'TotalLivros' => 2,
                'TotalEdicoes' => 2
            ],
            [
                'Assunto' => 'Saúde',
                'Editora' => 'MedTechBooks',
                'TotalLivros' => 1,
                'TotalEdicoes' => 1
            ],
            [
                'Assunto' => 'Tecnologia',
                'Editora' => 'Independente',
                'TotalLivros' => 2,
                'TotalEdicoes' => 2
            ],
            [
                'Assunto' => 'Tecnologia',
                'Editora' => 'MedTechBooks',
                'TotalLivros' => 1,
                'TotalEdicoes' => 1
            ]
        ];

        $this->assertEquals($esperado, $assuntosEditoras);

        // Testa se o endpoint da API retorna os mesmos dados da view
        $response = $this->getJson(route('api.relatorios.assuntos'));
        
        $response->assertStatus(200)
                 ->assertJsonCount($results->count())
                 ->assertJson($results->toArray());
        
        // Testa se a página web carrega
        $response = $this->get(route('relatorios.assuntos'));
        $response->assertStatus(200)
                 ->assertViewHas('assuntos')
                 ->assertSee('Tecnologia')
                 ->assertSee('TechBooks');
    }
}
