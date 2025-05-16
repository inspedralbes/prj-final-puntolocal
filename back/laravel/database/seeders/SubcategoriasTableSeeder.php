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
        Subcategoria::create(["categoria_id" => 1, "name" => "Roba Formal"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Roba Casual"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Uniformes"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Accessoris"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Eventos"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Temporada"]);
        Subcategoria::create(["categoria_id" => 1, "name" => "Llenceria"]);

        // Tecnología
        Subcategoria::create(["categoria_id" => 2, "name" => "Electrònica"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Components PC"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Accessoris Mòbil"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Impressores"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Domòtica"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Videojocs"]);
        Subcategoria::create(["categoria_id" => 2, "name" => "Àudio i So"]);

        // Hogar y Decoración
        Subcategoria::create(["categoria_id" => 3, "name" => "Interior"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Exterior"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Cuina"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Tèxtils"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Quadres i Art"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Neteja"]);
        Subcategoria::create(["categoria_id" => 3, "name" => "Decoració Estacional"]);

        // Salud y Belleza
        Subcategoria::create(["categoria_id" => 4, "name" => "Cura de Pell"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Maquillatge Professional"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Cura Capil·lar"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Higiene Personal"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Equips Mèdics"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Perfumeria"]);
        Subcategoria::create(["categoria_id" => 4, "name" => "Bellesa"]);

        // Jugueterías
        Subcategoria::create(["categoria_id" => 5, "name" => "Joguines Clàssiques"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Jocs Educatius"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Bebès"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Nines i Figures"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Vehicles"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Construcció"]);
        Subcategoria::create(["categoria_id" => 5, "name" => "Electrònics"]);

        // Ferreterías
        Subcategoria::create(["categoria_id" => 6, "name" => "Eines Manuals"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Eines Elèctriques"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Construcció"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Pintures"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Jardineria"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Seguretat Industrial"]);
        Subcategoria::create(["categoria_id" => 6, "name" => "Panys"]);

        // Librerías
        Subcategoria::create(["categoria_id" => 7, "name" => "Llibres Escolars"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Literatura General"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Papereria"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Articles d'Art"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Jocs de taula"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Material Didàctic"]);
        Subcategoria::create(["categoria_id" => 7, "name" => "Revistes i Periòdics"]);

        // Farmacias
        Subcategoria::create(["categoria_id" => 8, "name" => "Medicaments"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Vitamines"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Cura Personal"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Productes Naturals"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Primera Ajuda"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Salut Infantil"]);
        Subcategoria::create(["categoria_id" => 8, "name" => "Equips Mèdics"]);

        // Zapaterías
        Subcategoria::create(["categoria_id" => 9, "name" => "Sabates Esportives"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Calçat Formal"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Xancletes"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Nens"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Botes"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Calçat Casual"]);
        Subcategoria::create(["categoria_id" => 9, "name" => "Accessoris"]);

        // Floristerías
        Subcategoria::create(["categoria_id" => 10, "name" => "Rams"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Interior"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Exterior"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Arranjaments Florals"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Artificials"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Tests"]);
        Subcategoria::create(["categoria_id" => 10, "name" => "Decoració Floral"]);

        // Ópticas
        Subcategoria::create(["categoria_id" => 11, "name" => "Lents Oftàlmics"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Lents de Sol"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Lents de Contacte"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Muntures"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Accessoris"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Cura Visual"]);
        Subcategoria::create(["categoria_id" => 11, "name" => "Equips d'Examen"]);

        // Accesorios
        Subcategoria::create(["categoria_id" => 12, "name" => "Bosses i Carteres"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Joieria"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Rellotges"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Barrets i Capells"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Ulleres de Sol"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Cinturons"]);
        Subcategoria::create(["categoria_id" => 12, "name" => "Bufandes i Guants"]);

        // Tiendas de Mascotas
        Subcategoria::create(["categoria_id" => 13, "name" => "Aliments"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Accessoris"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Joguines"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Higiene i Salut"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Roba"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Ensinistrament"]);
        Subcategoria::create(["categoria_id" => 13, "name" => "Aquaris i Terraris"]);
    }
}
