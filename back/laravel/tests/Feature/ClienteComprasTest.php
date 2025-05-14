<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClienteComprasTest extends TestCase
{
    use RefreshDatabase;

    private $cliente;
    private $token;
    private $order;

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

        // Crear un cliente con los datos mínimos
        $this->cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        // Crear un token de acceso para el cliente
        $this->token = $this->cliente->createToken('API Token')->plainTextToken;

        // Crear una orden para este cliente
        $this->order = Order::create([
            'tipo_envio' => 1,
            'tipo_pago' => 1,
            'total' => 100.00,
            'cliente_id' => $this->cliente->id,
            'estat' => 1,
        ]);
    }

    /**
     * Test de obtener los datos del cliente.
     */
    public function test_obtener_datos_cliente()
    {
        $response = $this->getJson("/api/clientes/{$this->cliente->id}", [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nombre' => 'Cliente',
                'apellidos' => 'ClienteApellidos',
                'email' => 'cliente@example.com',
            ]);
    }

    /**
     * Test de obtener las compras de un cliente.
     */
    public function test_compras_cliente()
    {
        $response = $this->getJson("/api/clientes/{$this->cliente->id}/compras", [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'total' => 100.00,
            ]);
    }

    /**
     * Test de obtener los detalles de una compra.
     */
    public function test_detalle_compra()
    {
        $response = $this->getJson("/api/clientes/compras/{$this->order->id}", [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'total' => 100.00,
            ]);
    }
}
