<?php
namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriasTableSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ["name" => "Indumentària", "imagenes" => "https://www.svgrepo.com/show/438391/clothes.svg"],
            ["name" => "Tecnologia", "imagenes" => "https://www.svgrepo.com/show/394288/mobile.svg"],
            ["name" => "Llar", "imagenes" => "https://www.svgrepo.com/show/500894/home.svg"],
            ["name" => "Cosmètics", "imagenes" => "https://www.svgrepo.com/show/220295/cosmetics.svg"],
            ["name" => "Joguines", "imagenes" => "https://www.svgrepo.com/show/127406/toy-train.svg"],
            ["name" => "Ferreteries", "imagenes" => "https://www.svgrepo.com/show/393298/hardware.svg"],
            ["name" => "Llibreries", "imagenes" => "https://www.svgrepo.com/show/327322/library.svg"],
            ["name" => "Farmàcies", "imagenes" => "https://www.svgrepo.com/show/399495/health-services.svg"],
            ["name" => "Sabateries", "imagenes" => "https://www.svgrepo.com/show/482540/shoe-8.svg"],
            ["name" => "Floristeries", "imagenes" => "https://www.svgrepo.com/show/334681/florist.svg"],
            ["name" => "Òptiques", "imagenes" => "https://www.svgrepo.com/show/197909/goggles.svg"],
            ["name" => "Accessoris", "imagenes" => "https://www.svgrepo.com/show/482631/necklace-1.svg"],
            ["name" => "Mascotes", "imagenes" => "https://www.svgrepo.com/show/354654/pet-14.svg"],
        ];
        Categoria::insert($categorias);
    }
}