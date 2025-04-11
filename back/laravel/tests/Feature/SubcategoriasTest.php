<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class SubcategoriasTest extends TestCase
{
    use RefreshDatabase;

    private $categoria;
    private $subcategoria;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear una categoría
        DB::table('categorias')->insert([
            'id' => 1,
            'name' => 'CategoriaTest',
            'imagenes' => 'ImagenTest'
        ]);
        $this->categoria = Categoria::find(1);

        DB::table('subcategorias')->insert([
            'id' => 1,
            'categoria_id' => $this->categoria->id,
            'name' => 'SubcategoriaTest'
        ]);
        $this->subcategoria = Subcategoria::find(1);
    }

    /**
     * Test de obtener las subcategorías de una categoría.
     */
    public function test_show_subcategorias()
    {
        $response = $this->getJson("/api/subcategorias/{$this->categoria->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'SubcategoriaTest',
            ]);
    }

    /**
     * Test de obtener subcategorías de una categoría que no existe.
     */
    public function test_show_subcategorias_not_found()
    {
        $response = $this->getJson("/api/subcategorias/99999");

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'No s\'han trobat subcategories',
            ]);
    }
}

