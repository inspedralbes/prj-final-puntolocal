<?php

namespace Tests\Feature;

use App\Models\EstatCompra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EstatCompraTest extends TestCase
{
    use RefreshDatabase;
    public function test_index()
    {
        // Crear algunos estados de compra si es necesario para la prueba
        DB::table('estat_compras')->insert([
            [
            'nombre' => 'Pendiente',
            'color' => '#FF0000',
            ],
            [
            'nombre' => 'Completado',
            'color' => '#00FF00',
            ],
        ]);

        // Hacer la solicitud GET
        $response = $this->getJson('/api/admin/estats');

        // Asegúrate de que la respuesta tenga el código de estado correcto
        $response->assertStatus(200);

        // Asegúrate de que la respuesta contenga los estados esperados
        $response->assertJsonStructure([
            '*' => [
                'id',
                'nombre',
                'color'
            ],
        ]);
    }

}
