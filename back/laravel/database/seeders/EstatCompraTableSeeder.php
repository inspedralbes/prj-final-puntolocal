<?php
    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\EstatCompra;

    class EstatCompraTableSeeder extends Seeder {
        public function run(): void {
            EstatCompra::insert([
                ['nombre' => 'Pendiente', 'color'=>'#ffb300'],
                ['nombre' => 'Procesando', 'color'=>'#ff9ef5'],
                ['nombre' => 'Enviado', 'color'=>'#006dd9'],
                ['nombre' => 'Entregado', 'color'=>'#16d900'],
                ['nombre' => 'Cancelado', 'color'=>'#ff0000']
            ]);
        }
    }