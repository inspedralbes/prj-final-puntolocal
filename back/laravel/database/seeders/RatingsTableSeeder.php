<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $rateableTypes = [
            'App\Models\Producto' => 100,  // hay 100 productos
            'App\Models\Comercio' => 20,   // hay 20 comercios
        ];

        $combinacionesUsadas = [];

        $ratingsGenerados = 0;
        $ratingsDeseados = 200;

        while ($ratingsGenerados < $ratingsDeseados) {
            $clienteId = $faker->numberBetween(1, 10);
            $rateableType = $faker->randomElement(array_keys($rateableTypes));
            $maxId = $rateableTypes[$rateableType];
            $rateableId = $faker->numberBetween(1, $maxId);

            $claveUnica = "$clienteId-$rateableType-$rateableId";

            // Evitamos duplicados
            if (isset($combinacionesUsadas[$claveUnica])) {
                continue;
            }

            Rating::create([
                'cliente_id' => $clienteId,
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentences(rand(1, 3), true),
                'rateable_id' => $rateableId,
                'rateable_type' => $rateableType,
            ]);

            $combinacionesUsadas[$claveUnica] = true;
            $ratingsGenerados++;
        }
    }
}
