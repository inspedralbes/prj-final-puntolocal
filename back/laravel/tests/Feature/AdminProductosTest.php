<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Models\Comercio;
use App\Models\Producto;
use Tests\TestCase;

class AdminProductosTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $categoria;
    private $subcategoria;
    private $comercio;
    private $producto;
    private $token;

    // Configuración inicial para las pruebas
    protected function setUp(): void
    {
        parent::setUp();

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

        // Crear un cliente y generar el token para autenticación
        $this->cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);
        $this->token = $this->cliente->createToken('API Token')->plainTextToken;

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
            'categoria_id' => $this->categoria->id,
            'descripcion' => 'Atque delectus laboriosam porro maiores.',
            'gestion_stock' => 0,
            'puntaje_medio' => 0,
            'latitude' => 39.382378,
            'longitude' => -28.574012,
            'imagen' => null
        ]);

        // Crear un producto para este comercio
        $this->producto = Producto::create([
            'subcategoria_id' => $this->subcategoria->id,
            'comercio_id' => $this->comercio->id,
            'nombre' => 'ProductoTest',
            'descripcion' => 'Descripción del ProductoTest',
            'precio' => 100.00,
            'stock' => 10,
            'imagen' => 'imagen.jpg',
        ]);
    }

    // Prueba para crear un nuevo producto
    public function testCrearProducto()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/producto', [
                    'subcategoria_id' => 1,
                    'comercio_id' => $this->comercio->id,
                    'nombre' => 'NuevoProducto',
                    'descripcion' => 'Descripción de NuevoProducto',
                    'precio' => 50.00,
                    'stock' => 5,
                    'imagen' => new UploadedFile(
                        storage_path('app/public/productoTest.png'),
                        'producto.jpg',
                        null,
                        null,
                        true
                    ),
                ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Producto creado con éxito.',
                'producto' => [
                    'nombre' => 'NuevoProducto',
                    'descripcion' => 'Descripción de NuevoProducto',
                    'precio' => 50.00,
                    'stock' => 5,
                ]
            ]);
    }

    // Prueba para actualizar un producto existente
    public function testActualizarProducto()
    {
        $response = $this->postJson('/api/producto/' . $this->producto->id, [
            'nombre' => 'ProductoActualizado',
            'descripcion' => 'Descripción del ProductoActualizado',
            'precio' => 120.00,
            'stock' => 8,
            'subcategoria_id' => 1,
            'comercio_id' => $this->comercio->id,
            'imagen' => new UploadedFile(
                storage_path('app/public/productoTest.png'),
                'producto.jpg',
                null,
                null,
                true
            ),
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Producto actualizado con éxito',
                'data' => [
                    'nombre' => 'ProductoActualizado',
                    'descripcion' => 'Descripción del ProductoActualizado',
                    'precio' => 120.00,
                    'stock' => 8,
                ]
            ]);
    }

    // Prueba para actualizar la visibilidad de un producto
    public function testActualizarVisibilidadProducto()
    {
        $response = $this->postJson('/api/producto/visible/' . $this->producto->id, [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    // Prueba para eliminar un producto
    public function testEliminarProducto()
    {
        $response = $this->deleteJson('/api/producto/' . $this->producto->id, [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Producto eliminado con éxito',
            ]);
    }
}
