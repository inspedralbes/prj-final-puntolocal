<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CategoriaGeneral;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ATipoEnviosTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(SubcategoriasTableSeeder::class);
        $this->call(ComerciosTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ComprasRealizadasTableSeeder::class);
        $this->call(ProductosCompraTableSeeder::class);
    }
}
