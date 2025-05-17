<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Comercio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CategoriasTest extends TestCase
{
    private $comercio;
    private $cliente;
    private $token;
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
            'name' => 'Electrónica',
            'imagenes' => 'img.jpg',
        ]);

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
    public function test_index_categorias()
    {
        // Hacer la solicitud GET
        $response = $this->getJson('/api/categorias');

        // Asegúrate de que la respuesta tenga el código de estado correcto
        $response->assertStatus(200);

        // Asegúrate de que la respuesta contenga las categorías esperadas
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'imagenes'
            ],
        ]);
    }

    public function test_comercios_of_categoria()
    {
        // Hacer la solicitud GET para obtener los comercios de la categoría
        $response = $this->getJson('/api/categorias/' . 1 . '/comercios');

        // Asegúrate de que la respuesta tenga el código de estado correcto
        $response->assertStatus(200);
    }

    public function test_comercios_of_categoria_no_found()
    {
        // Hacer la solicitud GET para obtener los comercios de una categoría inexistente
        $response = $this->getJson('/api/categorias/99999/comercios');

        // Asegúrate de que la respuesta tenga el código de estado correcto
        $response->assertStatus(404);

        // Verifica que se reciba un mensaje indicando que no se encontraron categorías
        $response->assertJson(['message' => "No s'han trobat categorias"]);
    }

}
