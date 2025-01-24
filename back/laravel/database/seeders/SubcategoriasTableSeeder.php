<?php

namespace Database\Seeders;

use App\Models\Subcategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Indumentaria
        Subcategoria::create(["categoria_id" => 1, "name" => "Ropa Formal"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Ropa Casual"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Uniformes"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Accesorios de Moda"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Ropa para Eventos"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Ropa de Temporada"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Lencería"]);

        // Tecnología
        Subcategoria::create(["categoria_id" => 2, "name" => "Electrónica de Consumo"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Componentes de PC"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Accesorios de Teléfonos"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Impresoras y Escáneres"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Domótica"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Videojuegos"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Audio y Sonido Profesional"]);

        // Hogar y Decoración
        Subcategoria::create(["categoria_id" => 3, "name" => "Muebles de Interior"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Muebles de Exterior"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Artículos de Cocina"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Textiles para el Hogar"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Cuadros y Arte Decorativo"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Artículos de Limpieza"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Decoración Estacional"]);

        // Salud y Belleza
        Subcategoria::create(["categoria_id" => 4, "name" => "Cuidado de la Piel"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Maquillaje Profesional"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Cuidado Capilar"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Higiene Personal"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Equipos Médicos"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Perfumería"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Salones de Belleza"]);

        // Verdulería
        Subcategoria::create(["categoria_id" => 5, "name" => "Frutas de Temporada"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Vegetales Frescos"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Hierbas Aromáticas"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Legumbres"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Productos Orgánicos"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Snacks Saludables"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Jugos y Extractos Naturales"]);

        // Carnicerías
        Subcategoria::create(["categoria_id" => 6, "name" => "Carne de Res"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Carne de Cerdo"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Aves"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Embutidos"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Carne Marinada"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Productos Gourmet"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Cortes Especiales"]);

        // Jugueterías
        Subcategoria::create(["categoria_id" => 7, "name" => "Juguetes Clásicos"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Juegos Educativos"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Accesorios para Bebés"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Muñecas y Figuras"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Vehículos a Escala"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Juegos de Construcción"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Juguetes Electrónicos"]);

        // Ferreterías
        Subcategoria::create(["categoria_id" => 8, "name" => "Herramientas Manuales"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Herramientas Eléctricas"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Materiales de Construcción"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Pinturas y Accesorios"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Jardinería"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Seguridad Industrial"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Cerraduras y Herrajes"]);

        // Librerías
        Subcategoria::create(["categoria_id" => 9, "name" => "Libros Escolares"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Literatura General"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Papelería"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Artículos de Arte"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Juegos de Mesa"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Material Didáctico"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Revistas y Periódicos"]);

        // Farmacias
        Subcategoria::create(["categoria_id" => 10, "name" => "Medicamentos"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Vitaminas y Suplementos"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Cuidado Personal"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Productos Naturales"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Primera Ayuda"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Salud Infantil"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Equipos Médicos"]);

        // Zapaterías
        Subcategoria::create(["categoria_id" => 11, "name" => "Zapatos Deportivos"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Calzado Formal"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Sandalias y Chanclas"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Zapatos para Niños"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Botas"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Calzado Casual"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Accesorios para Calzado"]);

        // Floristerías
        Subcategoria::create(["categoria_id" => 12, "name" => "Ramos de Flores"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Plantas de Interior"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Plantas de Exterior"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Arreglos Florales"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Flores Artificiales"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Macetas y Accesorios"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Decoración Floral"]);

        // Ópticas
        Subcategoria::create(["categoria_id" => 13, "name" => "Lentes Oftálmicos"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Lentes de Sol"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Lentes de Contacto"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Monturas para Lentes"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Soluciones y Accesorios"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Cuidado Visual"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Equipos de Examen"]);

        // Accesorios
        Subcategoria::create(["categoria_id" => 14, "name" => "Bolsos y Carteras"]);
        Subcategoria::create(["categoria_id" => 14, "name" => "Joyería"]);
        Subcategoria::create(["categoria_id" => 14, "name" => "Relojes"]);
        Subcategoria::create(["categoria_id" => 14, "name" => "Sombreros y Gorros"]);
        Subcategoria::create(["categoria_id" => 14, "name" => "Gafas de Sol"]);
        Subcategoria::create(["categoria_id" => 14, "name" => "Cinturones"]);
        Subcategoria::create(["categoria_id" => 14, "name" => "Bufandas y Guantes"]);

        // Tiendas de Mascotas
        Subcategoria::create(["categoria_id" => 15, "name" => "Alimentos para Mascotas"]);
        Subcategoria::create(["categoria_id" => 15, "name" => "Accesorios para Mascotas"]);
        Subcategoria::create(["categoria_id" => 15, "name" => "Juguetes para Mascotas"]);
        Subcategoria::create(["categoria_id" => 15, "name" => "Higiene y Salud"]);
        Subcategoria::create(["categoria_id" => 15, "name" => "Ropa para Mascotas"]);
        Subcategoria::create(["categoria_id" => 15, "name" => "Adiestramiento"]);
        Subcategoria::create(["categoria_id" => 15, "name" => "Acuarios y Terrarios"]);
    }
}
