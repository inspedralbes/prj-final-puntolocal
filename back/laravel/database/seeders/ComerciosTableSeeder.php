<?php
namespace Database\Seeders;

use App\Models\Comercio;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ComerciosTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $comercios = [
            "Boutique Castelldefels",
            "Marina Moda",
            "Tech & More",
            "Ferretería El Faro",
            "Belleza Urbana",
            "Repuestos Auto Express",
            "Home & Decor Hub",
            "Accesorios Chic",
            "Electrónica Viva",
            "Cosmética Natural"
        ];

        $comercios_email = [
            "contacto@boutiquecastelldefel.com",
            "info@marinamoda.com",
            "soporte@techandmore.com",
            "ventas@ferreteriaelfaro.com",
            "contacto@bellezaurbana.com",
            "info@repuestosautoexpress.com",
            "contacto@homedecorhub.com",
            "ventas@accesorioschic.com",
            "info@electronica-viva.com",
            "contacto@cosmeticanatural.com"
        ];

        $comercios_calles = [
            "Carrer del Doctor Ferran, 15",
            "Calle de la Coruña, 26",
            "Avinguda de la Constitució, 10",
            "Carrer Castanyer, 25",
            "Avinguda de la Mediterrània, 8",
            "Carrer de la Fàbrica, 12",
            "Carrer de la Salut, 18",
            "Avinguda del Mar, 5",
            "Passeig Marítim, 3",
            "Carrer de l'Església, 11"
        ];

        $comercios_latitudes = [
            41.280334,
            41.273167,
            41.285520,
            41.278500,
            41.274500,
            41.282500,
            41.286000,
            41.278000,
            41.275500,
            41.283000
        ];

        $comercios_longitudes = [
            1.9753008,
            1.979194,
            1.989394,
            1.970000,
            1.980500,
            1.977000,
            1.980000,
            1.987000,
            1.990000,
            1.976000
        ];

        $comercios_categorias = [1, 1, 2, 6, 4, 6, 3, 1, 2, 4];

        $comercios_descripciones = [
            "Boutique Castelldefels ofrece una cuidada selección de ropa y accesorios exclusivos. Con un ambiente elegante y un servicio personalizado, es ideal para quienes buscan tendencias únicas y calidad en cada prenda.",
            "Marina Moda fusiona el estilo costero con la moda urbana. Sus colecciones frescas y modernas inspiran un look relajado y chic, perfecto para el día a día en un entorno mediterráneo.",
            "Tech & More es tu destino para lo último en tecnología. Ofrece gadgets, dispositivos inteligentes y accesorios de alta calidad, con asesoramiento experto para facilitar tus compras tecnológicas.",
            "Ferretería El Faro es una tienda tradicional que provee herramientas, materiales y productos para el hogar y la construcción. Su servicio cercano y profesional satisface tanto a particulares como a profesionales.",
            "Belleza Urbana se especializa en cosméticos y productos de belleza. Con una oferta actualizada y de alta calidad, realza tu belleza natural y te mantiene al tanto de las últimas tendencias en maquillaje y cuidado personal.",
            "Repuestos Auto Express ofrece una amplia gama de piezas y accesorios para vehículos. Con productos de calidad y un servicio rápido, es la opción ideal para mantener tu coche en perfecto estado.",
            "Home & Decor Hub es el punto de referencia en decoración y mobiliario del hogar. Su variada selección de artículos modernos y clásicos permite transformar cualquier espacio en un ambiente acogedor y estilizado.",
            "Accesorios Chic presenta una cuidada selección de complementos de moda, desde joyería hasta bolsos y gafas. Sus diseños innovadores y de alta calidad aportan un toque distintivo a cualquier outfit.",
            "Electrónica Viva se dedica a la venta de productos electrónicos y gadgets de última generación. Con un amplio catálogo que abarca smartphones, sistemas audiovisuales y más, garantiza tecnología avanzada para todos.",
            "Cosmética Natural ofrece productos de belleza ecológicos y orgánicos. Su línea de cuidado de la piel y maquillaje, formulada con ingredientes naturales, es ideal para quienes buscan calidad y sostenibilidad en su rutina de belleza."
        ];

        $cantidad = 10;

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table('comercios')->insert([
                'nombre' => $comercios[$i],
                'idUser' => $i + 1,
                'phone' => "603" . $faker->numberBetween(100000, 999999),
                'email' => $comercios_email[$i],
                'calle_num' => $comercios_calles[$i],
                'ciudad' => "Castelldefels",
                'provincia' => "Barcelona",
                'codigo_postal' => '08860',
                'num_planta' => '0',
                'num_puerta' => '0',
                'categoria_id' => $comercios_categorias[$i],
                'descripcion' => $comercios_descripciones[$i],
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
            ]);
        }
    }
}