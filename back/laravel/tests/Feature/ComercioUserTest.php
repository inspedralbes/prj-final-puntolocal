<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Comercio;
use App\Models\Producto;

class ComercioUserTest extends TestCase
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

        $this->token = $this->cliente->createToken('API Token')->plainTextToken;

        DB::table('categorias')->insert([
            'id' => 1,
            'name' => 'CategoriaTest',
            'imagenes' => 'ImagenTest'
        ]);

        DB::table('subcategorias')->insert([
            'id' => 1,
            'categoria_id' => 1,
            'name' => 'SubcategoriaTest'
        ]);

        // Crear un comercio para pruebas
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

        // Crear un producto para el comercio
        Producto::create([
            'subcategoria_id' => 1,
            'comercio_id' => $this->comercio->id,
            'nombre' => 'ProductoTest',
            'descripcion' => 'DescripcionTest',
            'precio' => 10,
            'stock' => 10,
            'imagen' => json_encode('image1.jpg'),
        ]);
    }

    /**
     * Test de obtener un comercio por ID.
     */
    public function test_get_comercio()
    {
        $response = $this->getJson("/api/comercios/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'comercio',
                'productos' => [
                    '*' => ['producto_id', 'nombre', 'descripcion', 'precio', 'stock', 'imagen', 'altitud', 'latitud', 'subcategoria'],
                ],
            ]);
    }

    /**
     * Test de búsqueda de comercios.
     */
    public function test_search_comercios()
    {
        $response = $this->getJson('/api/comercios/search/ComercioTest');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->comercio->id,
                        'nombre' => $this->comercio->nombre,
                        'categoria_id' => $this->comercio->categoria_id,
                        'puntaje_medio' => $this->comercio->puntaje_medio,
                        'imagenes' => $this->comercio->imagenes,
                        'horario' => $this->comercio->horario,
                    ]
                ]
            ]);
    }

    /**
     * Test de obtener el ID de usuario asociado a un comercio.
     */
    public function test_get_user_id()
    {
        $response = $this->getJson("/api/comercios/getUserid/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJson([
                'usuario_id' => $this->comercio->id,
            ]);
    }

    /**
     * Test de obtener comercios cercanos a coordenadas.
     */
    public function test_get_comercios_cercanos()
    {
        $response = $this->getJson("/api/comercios/comercios-cercanos/40.7128/-74.0060");

        $response->assertStatus(200);
    }

    /**
     * Test de obtener las ubicaciones verificadas de los comercios.
     */
    public function test_get_locations()
    {
        $response = $this->getJson('/api/getLocations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'comercios' => [
                    '*' => ['id', 'nombre', 'latitude', 'longitude', 'puntaje_medio', 'horario', 'phone', 'email', 'calle_num', 'categoria_id', 'imagen'],
                ]
            ]);
    }
}

