<?php
    namespace Database\Seeders;

    use App\Models\Comercio;
    use Faker\Factory as Faker;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Carbon;

    class ComerciosTableSeeder extends Seeder {
        public function run(): void {
            $faker = Faker::create();

            $cantidad = 12;

            for ($i = 0; $i < $cantidad; $i++) {
                DB::table('comercios')->insert([
                    'nombre' => $faker->company,
                    'idUser' => $i + 1,
                    'phone' => "603" . $faker->numberBetween(100000, 999999),
                    'email' => $faker->companyEmail,
                    'calle_num' => $faker->streetAddress,
                    'ciudad' => "Castelldefels",
                    'provincia' => "Barcelona",
                    'codigo_postal' => '08860',
                    'num_planta' => $faker->numberBetween(1, 5),
                    'num_puerta' => $faker->numberBetween(1, 100),
                    'categoria_id' => rand(1, 10),
                    'descripcion' => $faker->paragraph,
                    'gestion_stock' => rand(0, 1),
                    'puntaje_medio' => $faker->randomFloat(1, 1, 5),
                    'imagenes' => json_encode([$faker->imageUrl()]),
                    'horario' => json_encode([
                        'lunes' => '09:00 - 18:00',
                        'martes' => '09:00 - 18:00',
                        'miércoles' => '09:00 - 18:00',
                        'jueves' => '09:00 - 18:00',
                        'viernes' => '09:00 - 18:00',
                        'sábado' => '10:00 - 14:00',
                        'domingo' => 'Cerrado',
                    ]),
                    'latitude' => $i === 8 ? '41.383741' : null,
                    'longitude' => $i === 8 ? '2.101861' : null,
                    'ubicacion_verified_at' => $i === 8 ? now() : null,
                ]);
            }
        }
    }