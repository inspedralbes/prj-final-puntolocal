<?php
    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\Categoria;

    class CategoriasTableSeeder extends Seeder {
        public function run(): void {
            // Categoria::create(["name" => "Indumentaria"]);
            $categorias = [
                ["name" => "Indumentaria"],
                ["name" => "Tecnología"],
                ["name" => "Hogar y Decoración"],
                ["name" => "Salud y Belleza"],
                ["name" => "Verdulería"],
                ["name" => "Carnicerías"],
                ["name" => "Jugueterías"],
                ["name" => "Ferreterías"],
                ["name" => "Librerías"],
                ["name" => "Farmacias"],
                ["name" => "Zapaterías"],
                ["name" => "Floristerías"],
                ["name" => "Ópticas"],
                ["name" => "Accesorios"],
                ["name" => "Tiendas de Mascotas"],
            ];
            
            Categoria::insert($categorias);
        }
    }