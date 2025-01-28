<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ComprasRealizadasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $cantidad = 10;

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table("orders")->insert([
                "cliente_id" => $faker->numberBetween(1,10),
                "fecha" => $faker->dateTimeBetween('2023-01-01', '2025-01-01'),
                "estat_id" => $faker->numberBetween(1,5),
                'total' => $faker->randomFloat(2, 5, 1000),
                'tipo_envio' => $faker->numberBetween(1, 2),
                'tipo_envio_id' => $faker->numberBetween(1,2),
                'created_at' => now(),
            ]);
        }
    }
}
