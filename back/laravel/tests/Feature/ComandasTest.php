<?php

namespace Tests\Feature;

use App\Models\Comercio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Order;
use App\Models\OrderComercio;
use App\Models\TipoEnvio;
use App\Models\TipoPago;
use Illuminate\Support\Facades\Auth;

class ComandasTest extends TestCase
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

        // Crear tipos de envio y pago


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

        // Autenticar al usuario
        $this->actingAs($this->cliente);
    }

    /**
     * Test de obtener todas las comandas de un usuario.
     */
    public function test_index()
    {
        $response = $this->getJson('/api/comandes');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'total' => 100.00,
            ]);
    }

    /**
     * Test de crear una nueva comanda.
     */
    public function test_store()
    {
        $data = [
            'tipo_envio' => 1,
            'tipo_pago' => 1,
            'total' => 200.00,
            'cliente_id' => $this->cliente->id,
            'estat' => 1
        ];

        $response = $this->postJson('/api/comandes', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Orden creada con éxito.',
            ]);
    }

    /**
     * Test de obtener las subcomandas de un comercio a partir de una orden general.
     */
    public function test_show_orders_comercios()
    {
        $response = $this->getJson("/api/comandes/{$this->order->id}/suborders");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'order_id' => $this->order->id,
            ]);
    }

    /**
     * Test de obtener una comanda específica.
     */
    public function test_show()
    {
        $response = $this->getJson("/api/comandes/{$this->order->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'total' => 100.00,
            ]);
    }

    /**
     * Test de obtener información de una subcomanda del cliente.
     */
    public function test_show_data()
    {
        $response = $this->getJson("/api/comandes/suborder/{$this->orderComercio->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'order_id' => $this->order->id,
            ]);
    }
}

