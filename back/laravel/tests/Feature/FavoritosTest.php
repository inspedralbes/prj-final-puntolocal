<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Comercio;
use App\Models\comercioFavoritos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FavoritosTest extends TestCase
{

    use RefreshDatabase;
    private $cliente;
    private $token;
    private $comercio;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        DB::table('categorias')->insert([
            'id' => 1,
            'name' => 'CategoriaTest',
            'imagenes' => 'ImagenTest'
        ]);

        $this->token = $this->cliente->createToken('API Token')->plainTextToken;

        $this->comercio = Comercio::create([
            'nombre' => 'ComercioTest',
            'idUser' => $this->cliente->id,
            'email' => 'comercio@example.com',
            'phone' => '123456789',
            'calle_num' => '2692 Corene Terrace',
            'ciudad' => 'Port Eleonoreside',
            'provincia' => 'Alaska',
            'codigo_postal' => 12345,
            'num_planta' => 8,
            'num_puerta' => 1,
            'categoria_id' => 1,
            'descripcion' => 'Atque delectus laboriosam porro maiores.',
            'gestion_stock' => 0,
            'puntaje_medio' => 0,
            'latitude' => 39.382378,
            'longitude' => -28.574012,
            'imagen' => null
        ]);
    }

    use RefreshDatabase;
    public function test_get_favoritos()
    {
        comercioFavoritos::create([
            'cliente_id' => $this->cliente->id,
            'comercio_id' => $this->comercio->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson('/api/favoritos/comercios-favoritos');


        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['comercio']
            ]);
    }

    public function test_afegir_like_comerci()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson("/api/favoritos/like/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Comercio añadido a favoritos']);

        // Verificar que el comercio ahora está en favoritos
        $this->assertDatabaseHas('comercios_favoritos', [
            'cliente_id' => $this->cliente->id,
            'comercio_id' => $this->comercio->id
        ]);

        // Eliminar el comercio de favoritos
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson("/api/favoritos/like/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Comercio eliminado de favoritos']);

        // Verificar que el comercio ya no está en favoritos
        $this->assertDatabaseMissing('comercios_favoritos', [
            'cliente_id' => $this->cliente->id,
            'comercio_id' => $this->comercio->id
        ]);
    }

    public function test_verificar_seguido()
    {
        // Asegurarse de que el comercio aún no está en favoritos
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson("/api/favoritos/verificar-seguido/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJson(['seguido' => false]);

        // Agregar el comercio a favoritos
        comercioFavoritos::create([
            'cliente_id' => $this->cliente->id,
            'comercio_id' => $this->comercio->id
        ]);

        // Verificar que el comercio ahora está seguido
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson("/api/favoritos/verificar-seguido/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJson(['seguido' => true]);
    }

}
