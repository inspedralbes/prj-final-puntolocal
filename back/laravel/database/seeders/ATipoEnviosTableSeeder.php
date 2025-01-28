<?php
    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class ATipoEnviosTableSeeder extends Seeder {
        public function run(): void {
            DB::table('tipo_envios')->insert([
                ['nombre' => 'Recollida a tenda'],
                ['nombre' => 'Envio a casa'],
            ]);
        }
    }