<?php

namespace Tests\Feature;

use App\Models\Comercio;
use App\Models\Cliente;
use App\Models\Order;
use App\Models\OrderComercio;
use App\Models\Producto;
use App\Models\ProductoOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SuborderTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $token;
    private $comercio;
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

        // Crear una subcomanda (OrderComercio)
        $this->orderComercio = OrderComercio::create([
            'order_id' => $this->order->id,
            'comercio_id' => $this->comercio->id,
            'subtotal' => 100.00,
            'estat' => 1,
        ]);

        // Crear algunos productos para la prueba
        $this->producto = Producto::create([
            'subcategoria_id' => 1,
            'comercio_id' => $this->comercio->id,
            'nombre' => 'ProductoTest',
            'descripcion' => 'DescripcionProductoTest',
            'precio' => 10.00,
            'stock' => 50,
        ]);

        // Autenticar al usuario
        $this->actingAs($this->cliente);
    }

    /**
     * Test de crear una nueva subcomanda.
     */
    public function test_store_suborder()
    {
        $data = [
            'order_id' => $this->order->id,
            'suborders' => [
                [
                    'comercio_id' => $this->comercio->id,
                    'subtotal' => 50.00,
                    'productos' => [
                        [
                            'id' => $this->producto->id,
                            'cantidad' => 2,
                            'precio' => 10.00
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->postJson('/api/suborders', $data, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201);
    }
}

