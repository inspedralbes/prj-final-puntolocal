<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_info_cliente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
