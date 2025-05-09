<?php

namespace Tests\Feature;

use App\Models\Comercio;
use App\Models\Order;
use App\Models\OrderComercio;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class ComandasAdminTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $token;
    private $comercio;
    private $producto;
    private $order;
    private $orderComercio;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('estat_compras')->insert([
            'id' => 1,
            'nombre' => 'Pendiente',
            'color' => 'red'
        ]);
        
        DB::table('estat_compras')->insert([
            'id' => 4,
            'nombre' => 'Completada',
            'color' => 'green'
        ]);
        
        DB::table('estat_compras')->insert([
            'id' => 5,
            'nombre' => 'Cancelada',
            'color' => 'grey'
        ]);

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

        DB::table('tipo_envios')->insert([
            'id' => 1,
            'nombre' => 'Envío estándar',
            'descripcion' => 'DescripcionTest'
        ]);

        DB::table('tipo_pagos')->insert([
            'id' => 1,
            'nombre' => 'Tarjeta de crédito',
        ]);

        // Crear un usuario para realizar las pruebas
        $this->cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
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

        // Crear una orden para este usuario
        $this->order = Order::create([
            'tipo_envio' => 1,
            'tipo_pago' => 1,
            'total' => 100.00,
            'cliente_id' => $this->cliente->id,
            'estat' => 1,
        ]);

        // Crear una subcomanda finalizada (OrderComercio)
        $this->orderComercio = OrderComercio::create([
            'id' => 1,
            'order_id' => $this->order->id,
            'comercio_id' => $this->comercio->id,
            'subtotal' => 100.00,
            'estat' => 4,
        ]);

        // Crear una subcomanda pendiente (OrderComercio)
        $this->orderComercio = OrderComercio::create([
            'id' => 2,
            'order_id' => $this->order->id,
            'comercio_id' => $this->comercio->id,
            'subtotal' => 100.00,
            'estat' => 1,
        ]);

        $this->producto = Producto::create([
            "id" => 1,
            "nombre" => 'ProductoTest',
            "descripcion" => 'DescripcionTest',
            "subcategoria_id" => 1,
            "comercio_id" => $this->comercio->id,
            "precio" => 10,
            "stock" => 10,
            "visible" => 1
        ]);

        // Autenticar al usuario
        $this->actingAs($this->cliente);
    }

    /**
     * Test de obtener todas las comandas activas de un comercio.
     */
    public function test_index()
    {
        $response = $this->getJson('/api/admin/comandes');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'subtotal' => 100.00,
            ]);
    }

    /**
     * Test de obtener el historial de comandas.
     */
    public function test_historial_orders()
    {
        $response = $this->getJson('/api/admin/comandes/historial');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'subtotal' => 100.00,
            ]);
    }

    /**
     * Test de obtener una comanda específica.
     */
    public function test_show()
    {
        $response = $this->getJson("/api/admin/comandes/{$this->orderComercio->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'subtotal' => 100.00,
            ]);
    }

    /**
     * Test de crear una nueva comanda.
     */
    public function test_store()
    {
        $data = [
            'order_id' => $this->order->id,
            'suborders' => [
                [
                    'id' => 1,
                    'comercio_id' => $this->comercio->id,
                    'subtotal' => 50.00,
                    'productos' => [
                        [
                            'id' => $this->producto->id,
                            'cantidad' => 2,
                            'precio' => 20.00
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->postJson('/api/admin/comandes', $data);
        
        $response->assertStatus(201);
    }

    /**
     * Test de actualizar una comanda.
     */
    public function test_update()
    {
        $data = [
            'estat' => 4 // Completada
        ];

        $response = $this->postJson("/api/admin/comandes/{$this->orderComercio->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'estat' => 4,  // Completada
            ]);
    }
}
