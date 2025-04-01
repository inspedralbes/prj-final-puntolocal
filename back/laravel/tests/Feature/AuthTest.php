<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $data = [
            'name' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Suponiendo que el endpoint de registro es /api/register
        $response = $this->postJson('/api/auth/register', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'cliente' => ['id', 'name', 'email']
            ]);
    }
}
