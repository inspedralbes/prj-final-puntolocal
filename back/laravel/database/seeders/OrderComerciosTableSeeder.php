<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrderComerciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $cantidad = 10;
        $comercioIds = DB::table('comercios')->pluck('id')->toArray();

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table("order_comercios")->insert([
                'order_id' => $faker->numberBetween(1,9),
                'comercio_id' => $faker->randomElement($comercioIds),
                'subtotal' => $faker->randomFloat(2, 5, 1000),
                'estat' => $faker->numberBetween(1,5),
                'created_at' => $faker->dateTimeBetween('-10 days', 'now'),
            ]);
        }
    }
}
