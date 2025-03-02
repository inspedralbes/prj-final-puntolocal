<?php
    namespace Database\Seeders;

    use App\Models\Comercio;
    use Faker\Factory as Faker;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Carbon;

    class ComerciosSantAntoniTableSeeder extends Seeder {
        public function run(): void {
            $faker = Faker::create();
            
            $comercios_latitudes = [
                41.3789,
                41.3795,
                41.3778,
                41.3762,
                41.3801,
                41.3782,
                41.3790,
                41.3768,
                41.3775,
                41.3805
            ];

            $comercios_longitudes = [
                2.1611,
                2.1625,
                2.1600,
                2.1587,
                2.1632,
                2.1598,
                2.1617,
                2.1582,
                2.1609,
                2.1629
            ];

            $comercios_imagenes = [
                "https://assets.bwbx.io/images/users/iqjWHBFdfxIU/iwRjCe.Ybyv8/v1/-1x-1.jpg",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqnzB5y1yWvSZ4bohLsJE7C-VcGr2Bw8vxvQ&s",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcCj1n1Ex-QJAUs9vJjiK8tV-Rp5Jjyp6jgw&s",
                "https://media.richardmille.com/wp-content/uploads/2018/03/23170945/image2-v5-768x432.jpg?dpr=3&width=900",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQ2lEk_U58JMJRo4yaiYb9xeYGQqC99XEVyw&s",
                "https://static.nike.com/a/images/f_auto/92234393-1a90-400a-8491-4e40273435c7/image.jpeg",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTiSLWtoW-aREAl7ybE54fydGJDvYJ3I00QQ&s",
                "https://imgs.search.brave.com/Sna2nfvpYoOrxTUavXXHjg7gB9ubIJFJxyam53mLkUE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly91cGxv/YWQud2lraW1lZGlh/Lm9yZy93aWtpcGVk/aWEvY29tbW9ucy8w/LzAxL01lcmNhZG9u/YV9OdWV2b19Nb2Rl/bG9fZGVfVGllbmRh/Mi5qcGc",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqN1JaXDK6v0BGksvpRj3hKsfaHRBpRq4r3w&s",
                "https://imgs.search.brave.com/3maiqiPBNh_4XthVPHHBrOyHuyP9rQxkw5m_4CJZ00Q/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly91cGxv/YWQud2lraW1lZGlh/Lm9yZy93aWtpcGVk/aWEvY29tbW9ucy8y/LzIyL1B1bGxfYW5k/X2JlYXJfc3RvcmUu/anBn"
            ];

            $cantidad = 10;

            for ($i = 0; $i < $cantidad; $i++) {
                DB::table('comercios')->insert([
                    'nombre' => $faker->company,
                    'idUser' => $i + 1,
                    'phone' => "603" . $faker->numberBetween(100000, 999999),
                    'email' => $faker->unique()->companyEmail,
                    'calle_num' => $faker->streetAddress,
                    'ciudad' => "Castelldefels",
                    'provincia' => "Barcelona",
                    'codigo_postal' => '08860',
                    'num_planta' => '0',
                    'num_puerta' => '0',
                    'categoria_id' => $faker->numberBetween(1, 6),
                    'descripcion' => $faker->sentence(15),
                    'gestion_stock' => rand(0, 1),
                    'puntaje_medio' => $faker->randomFloat(1, 1, 5),
                    'imagenes' => json_encode([$faker->imageUrl()]),
                    'horario' => json_encode([
                        'lunes' => '09:00 - 18:00',
                        'martes' => '09:00 - 18:00',
                        'miércoles' => '09:00 - 18:00',
                        'jueves' => '09:00 - 18:00',
                        'viernes' => '09:00 - 18:00',
                        'sábado' => '10:00 - 20:00',
                        'domingo' => 'Cerrado',
                    ]),
                    'latitude' => $comercios_latitudes[$i],
                    'longitude' => $comercios_longitudes[$i],
                    'ubicacion_verified_at' => now(),
                    'imagen' => json_encode($comercios_imagenes[$i]),
                ]);
            }
        }
    }