<?php
    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class CategoriasConcretasSeeder extends Seeder {
        public function run() {
            DB::table('categorias_generales')->insert([
                [
                    'categoria' => 'vagilla',
                ],
            ]);

            DB::table('categorias_concretas')->insert([
                [
                    'nombre' => 'Tazas',
                    'id_categoria_general' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nombre' => 'Platos',
                    'id_categoria_general' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nombre' => 'Basos',
                    'id_categoria_general' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nombre' => 'Cubiertos',
                    'id_categoria_general' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                
            ]);

            DB::table('comercios')->insert([
                'id' => 1,  // Establecer el ID como 1
                'nombre' => 'Comercio Ejemplo',
                'email' => 'comercio@ejemplo.com',
                'email_verified_at' => now(),
                'phone' => '123456789',
                'phone_verified_at' => now(),
                'password' => bcrypt('contraseña_segura'),
                'calle_num' => 'Calle Falsa 123',
                'ciudad' => 'Ciudad Ejemplo',
                'provincia' => 'Provincia Ejemplo',
                'cp' => '12345',
                'num_planta' => 1,
                'num_puerta' => 2,
                'categoria_general_id' => 1,
                'descripcion' => 'Descripción del comercio de ejemplo.',
                'gestion_stock' => true,
                'puntaje_medio' => 4.5,
                'imagenes' => json_encode([
                    'https://example.com/images/comercio_imagen1.jpg',
                    'https://example.com/images/comercio_imagen2.jpg'
                ]),
                'horario' => json_encode([
                    'lunes' => '09:00-18:00',
                    'martes' => '09:00-18:00',
                    'miércoles' => '09:00-18:00',
                    'jueves' => '09:00-18:00',
                    'viernes' => '09:00-18:00',
                    'sábado' => '10:00-14:00',
                    'domingo' => 'cerrado'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }