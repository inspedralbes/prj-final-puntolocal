<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Testing\Fakes\Fake;
use Tests\TestCase;

class ComercioTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        $this->token = $this->cliente->createToken('API Token')->plainTextToken;

        DB::table('categorias')->insert([
            'id' => 1,
            'name' => 'CategoriaTest',
            'imagenes' => 'ImagenTest'
        ]);
    }

    public function test_comercio_can_register()
    {
        $data = [
            'nombre' => 'ComercioTest',
            'idUser' => $this->cliente->id,
            'email' => $this->cliente->email,
            'phone' => '123456789',
            'street_address' => fake()->streetAddress(),
            'ciudad' => fake()->city(),
            'provincia' => fake()->state(),
            'codigo_postal' => 12345,
            'num_planta' => fake()->randomDigitNotNull(),
            'num_puerta' => fake()->randomDigitNotNull(),
            'categoria' => 1,
            'descripcion' => fake()->sentence(),
            'gestion_stock' => 0,
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude()
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson('/api/comercios/', $data);


        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'comercio'
            ]);
    }

    // public function test_check_user_has_comercio()
    // {
    //     $cliente = Cliente::create([
    //         'name' => 'Cliente2',
    //         'apellidos' => 'Cliente2Apellidos',
    //         'email' => 'cliente2@example.com',
    //         'password' => Hash::make('password123')
    //     ]);

    //     $token = $cliente->createToken('API Token')->plainTextToken;

    //     $data = [
    //         'nombre' => 'ComercioTest',
    //         'idUser' => $cliente->id,
    //         'email' => $cliente->email,
    //         'phone' => '123456789',
    //         'street_address' => fake()->streetAddress(),
    //         'ciudad' => fake()->city(),
    //         'provincia' => fake()->state(),
    //         'codigo_postal' => 12345,
    //         'num_planta' => fake()->randomDigitNotNull(),
    //         'num_puerta' => fake()->randomDigitNotNull(),
    //         'categoria' => 1,
    //         'descripcion' => fake()->sentence(),
    //         'gestion_stock' => 0,
    //         'latitude' => fake()->latitude(),
    //         'longitude' => fake()->longitude()
    //     ];

    //     $responseCreate = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token
    //     ])->postJson('/api/comercios/', $data);
    //     $responseCreate->dump();

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token
    //     ])->getJson("/api/comercios/3");
    //     $response->dump();
    // }

    
}
