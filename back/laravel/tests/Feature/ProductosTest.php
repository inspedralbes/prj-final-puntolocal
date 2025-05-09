<?php

namespace Tests\Feature;

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

class ProductosTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $token;
    private $categoria;
    private $comercio;
    private $producto;

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
        
        // Insertar categorías y subcategorías de prueba
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

        // Crear un comercio
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

        // Crear un producto
        $this->producto = Producto::create([
            'nombre' => 'ProductoTest',
            'descripcion' => 'Descripcion del ProductoTest',
            'subcategoria_id' => 1,
            'comercio_id' => $this->comercio->id,
            'precio' => 10.0,
            'stock' => 100,
            'visible' => 1
        ]);
    }

    /**
     * Test de obtener todos los productos.
     */
    public function test_index()
    {
        $response = $this->getJson('/api/producto');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'ProductoTest',
                'precio' => 10.0,
            ]);
    }

    /**
     * Test de obtener productos aleatorios.
     */
    public function test_random_products()
    {
        $response = $this->getJson('/api/producto/random');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'ProductoTest',
            ]);
    }

    /**
     * Test de obtener productos por comercio.
     */
    public function test_get_by_comercio()
    {
        $response = $this->getJson("/api/producto/comercio/{$this->comercio->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'ProductoTest',
                'comercio' => 'ComercioTest',
            ]);
    }

    /**
     * Test de obtener un producto específico.
     */
    public function test_show()
    {
        $response = $this->getJson("/api/producto/{$this->producto->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'ProductoTest',
                'descripcion' => 'Descripcion del ProductoTest',
            ]);
    }

    /**
     * Test de búsqueda de productos.
     */
    public function test_search()
    {
        $response = $this->getJson("/api/producto/search/ProductoTest");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'ProductoTest',
            ]);
    }

    /**
     * Test de obtener productos por categoría.
     */
    public function test_get_productos_por_categoria()
    {
        $response = $this->getJson("/api/producto/categoria/{$this->categoria->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'ProductoTest',
            ]);
    }
}
