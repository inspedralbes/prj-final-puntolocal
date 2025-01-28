<?php
    namespace Database\Seeders;

    use App\Models\User;
    // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use App\Models\CategoriaGeneral;
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder {
        public function run(): void {
            $this->call(EstatsTableSeeder::class);
            $this->call(TipoEnviosTableSeeder::class);
            $this->call(ClientesTableSeeder::class);
            $this->call(CategoriasTableSeeder::class);
            $this->call(SubcategoriasTableSeeder::class);
            $this->call(ComerciosTableSeeder::class);
            $this->call(ProductosTableSeeder::class);

            // ORDERS
            $this->call(OrdersTableSeeder::class);
            $this->call(OrderComerciosTableSeeder::class);
            $this->call(ProductosCompraTableSeeder::class);
        }
    }