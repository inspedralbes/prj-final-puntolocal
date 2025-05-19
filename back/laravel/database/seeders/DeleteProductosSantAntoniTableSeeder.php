<?php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use App\Models\Producto;
    use App\Models\Comercio;

    class DeleteProductosSantAntoniSeeder extends Seeder {
        public function run(): void {
            $comercioIds = range(11, 20);

            Producto::whereIn('comercio_id', $comercioIds)->delete();

            Comercio::whereIn('id', $comercioIds)->delete();
        }
    }