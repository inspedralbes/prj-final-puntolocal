<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ATipoEnviosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_envios')->insert([
            ['nombre' => 'Cero envio posible'],
            ['nombre' => 'Primer envio posible'],
            ['nombre' => 'Segundo envio posible'],
        ]);
    }
}
