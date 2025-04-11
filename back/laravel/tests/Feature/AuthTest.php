<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

    public function test_user_can_login()
    {
        $cliente = Cliente::create([
            'name' => 'Login',
            'apellidos' => 'LoginApellidos',
            'email' => 'login@example.com',
            'password' => Hash::make('password123')
        ]);

        $data = [
            'email' => 'login@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user',
                'token'
            ]);
    }

    public function test_user_can_logout()
    {
        $cliente = Cliente::create([
            'name' => 'Logout',
            'apellidos' => 'LogoutApellidos',
            'email' => 'logout@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $cliente->createToken('API Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_user_can_change_password()
    {
        $cliente = Cliente::create([
            'name' => 'Logout',
            'apellidos' => 'LogoutApellidos',
            'email' => 'logout@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $cliente->createToken('API Token')->plainTextToken;

        $data = [
            'currentPassword' => 'password123',
            'newPassword' => 'newPassword123',
            'confirmPassword' => 'newPassword123'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/auth/change-password', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
