<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Comercio;
use App\Models\Producto;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_info_cliente(): void
    {
        $cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $cliente->createToken('API Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson("/api/cliente/{$cliente->id}");

        $response->assertStatus(200);
    }

    public function test_update_info_cliente()
    {
        $cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $cliente->createToken('API Token')->plainTextToken;

        $data = [
            'name' => 'newCliente',
            'apellidos' => 'newClienteApellidos',
            'email' => 'newcliente@exemple.com',
            'phone' => '123456789',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson("/api/cliente/{$cliente->id}/datos-personales", $data);

        $response->assertStatus(200);
    }

    public function test_get_user_favorites()
    {
        $cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $cliente->createToken('API Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/cliente/1/favoritos');

        $response->assertStatus(200);
    }

    public function test_toggle_favorites_and_get_info_favorites()
    {
        $cliente = Cliente::create([
            'name' => 'Cliente',
            'apellidos' => 'ClienteApellidos',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $cliente->createToken('API Token')->plainTextToken;

        DB::table('categorias')->insert([
            'name' => 'CategoriaTest',
            'imagenes' => 'ImagenTest'
        ]);
        $categoria = Categoria::where('name', 'CategoriaTest')->first();

        DB::table('subcategorias')->insert([
            'categoria_id' => $categoria->id,
            'name' => 'SubcategoriaTest'
        ]);
        $subcategoria = DB::table('subcategorias')->where('name', 'SubcategoriaTest')->first();

        $comercio = Comercio::create([
            'nombre' => 'ComercioTest',
            'idUser' => $cliente->id,
            'email' => 'emailTest@example.com',
            'calle_num' => 'Test 10',
            'ciudad' => 'CiudadTest',
            'provincia' => 'ProvinciaTest',
            'codigo_postal' => 00000,
            'categoria_id' => $categoria->id,
            'descripcion' => 'DescripcionTest',
            'gestion_stock' => 0,
            'puntaje_medio' => 3
        ]);

        $producto = Producto::create([
            "nombre" => 'ProductoTest',
            "descripcion" => 'DescripcionTest',
            "subcategoria_id" => $subcategoria->id,
            "comercio_id" => $comercio->id,
            "precio" => 10,
            "stock" => 10,
            "visible" => 1
        ]);

        $data = [
            'producto_id' => $producto->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson("/api/cliente/{$cliente->id}/favoritos", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);

        $responseGetInfo = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson("/api/cliente/{$cliente->id}/favoritos-info");

        $responseGetInfo->assertStatus(200);
    }
}
