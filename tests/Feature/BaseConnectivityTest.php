<?php

namespace Tests\Feature;

use Tests\TestCase;

class BaseConnectivityTest extends TestCase
{
    /**
     * Testar se aplicação funciona normalmente
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Testar se API funciona normalmente
     */
    public function test_the_api_returns_a_successful_response(): void
    {
        $response = $this->get('/api/status');

        $response->assertStatus(200);
    }
}
