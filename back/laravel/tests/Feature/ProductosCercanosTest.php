<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Comercio;
use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductosCercanosTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $token;
    private $comercio1;
    private $producto1;
    private $categoria;
    private $subcategoria;

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
        $this->categoria = Categoria::find(1);

        DB::table('subcategorias')->insert([
            'id' => 1,
            'categoria_id' => 1,
            'name' => 'SubcategoriaTest'
        ]);
        $this->subcategoria = Subcategoria::find(1);

        // Crear dos comercios
        $this->comercio1 = Comercio::create([
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

        // Crear productos para los comercios
        $this->producto1 = Producto::create([
            'nombre' => 'Producto1',
            'descripcion' => 'Descripción producto 1',
            'precio' => 100.00,
            'stock' => 10,
            'visible' => true,
            'comercio_id' => $this->comercio1->id,
            'subcategoria_id' => $this->subcategoria->id,
        ]);
    }

    /**
     * Test de obtener productos cercanos para comercios.
     */
    public function test_prueba()
    {
        // Enviar la petición con los IDs de los comercios
        $response = $this->getJson('/api/cercanos/productos?comercioIds=' . $this->comercio1->id);

        // Verificar la respuesta
        $response->assertStatus(200);
    }

    /**
     * Test con IDs de comercios inválidos.
     */
    public function test_prueba_invalid_comercio_ids()
    {
        $response = $this->getJson('/api/cercanos/productos?comercioIds=invalid,123');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Los IDs de los comercios deben ser números válidos',
            ]);
    }
}

