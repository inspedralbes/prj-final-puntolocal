<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $cantidad = 10;

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table("cliente")->insert([
                "name" => $faker->name,
                "apellidos" => $faker->lastName(),
                "email" => $faker->unique()->safeEmail,
                "phone" => "603" . $faker->numberBetween(100000, 999999),
                'password' => Hash::make("12345678"),
                "street_address" => $faker->streetAddress(),
                "ciudad" => "Castelldefels",
                "provincia" => "Barcelona",
                "codigo_postal" => $faker->numberBetween(00000, 99999),
                "numero_planta" => $faker->numberBetween(1, 10),
                "numero_puerta" => $faker->numberBetween(1, 99),
            ]);
        }
    }
}
