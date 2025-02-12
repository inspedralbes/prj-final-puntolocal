<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $productos = [
            "Ordenador portátil",
            "Smartphone",
            "Televisor LED 4K",
            "Auriculares inalámbricos",
            "Altavoz Bluetooth",
            "Reloj inteligente",
            "Camiseta deportiva",
            "Pantalones vaqueros",
            "Zapatillas de running",
            "Mochila escolar",
            "Lámpara de escritorio",
            "Sofá de tres plazas",
            "Mesa de comedor",
            "Silla ergonómica",
            "Juego de sábanas",
            "Cafetera espresso",
            "Batidora de mano",
            "Olla a presión",
            "Set de cuchillos de cocina",
            "Tabla de cortar de bambú",
            "Botella de agua reutilizable",
            "Mochila para senderismo",
            "Bicicleta de montaña",
            "Pelota de fútbol",
            "Juego de pesas",
            "Colchón viscoelástico",
            "Libro de recetas",
            "Juego de toallas",
            "Cepillo eléctrico",
            "Protector solar SPF 50",
            "Frigorífico doble puerta",
            "Lavadora automática",
            "Horno microondas",
            "Consola de videojuegos",
            "Videocámara de acción",
            "Set de pinceles para pintura",
            "Cuaderno de notas ecológico",
            "Bolígrafo de gel",
            "Caja de herramientas",
            "Taladro eléctrico",
            "Juego de mesa para niños",
            "Pack de alimentos orgánicos",
            "Chocolates artesanales",
            "Bolsa de frutos secos",
            "Botella de vino tinto",
            "Kit de jardinería",
            "Casco para bicicleta",
            "Maleta de viaje",
            "Perfume floral",
            "Ropa interior térmica",
            "Iphone 13 Pro Max"
        ];

        $descripciones = [
            "Un ordenador portátil de alto rendimiento, ideal tanto para trabajo como para entretenimiento, con pantalla de 15 pulgadas y batería de larga duración.",
            "Smartphone con cámara de 48 MP, procesador rápido y una pantalla OLED que ofrece una calidad de imagen impresionante, todo en un diseño compacto y moderno.",
            "Televisor LED 4K con tecnología HDR para que disfrutes de tus películas y series favoritas con una calidad de imagen nítida y colores vibrantes, además de ser compatible con todas las plataformas de streaming.",
            "Auriculares inalámbricos con cancelación de ruido activa, ofreciendo una experiencia de sonido envolvente y conectividad estable para que disfrutes de tu música sin interrupciones.",
            "Altavoz Bluetooth con un sonido claro y potente, ideal para llevar a cualquier lugar gracias a su tamaño compacto y su batería de larga duración.",
            "Reloj inteligente con funciones avanzadas de monitoreo de salud, como frecuencia cardíaca, seguimiento de actividad física y notificaciones de tu smartphone directamente en tu muñeca.",
            "Camiseta deportiva diseñada con tecnología que mantiene la piel fresca y seca durante el ejercicio, con un ajuste cómodo y materiales transpirables.",
            "Pantalones vaqueros de corte clásico, con una mezcla de algodón y elastano que proporciona comodidad y flexibilidad, perfectos para cualquier ocasión.",
            "Zapatillas de running con una suela especializada para absorber impactos y ofrecer mayor comodidad y soporte durante carreras largas o entrenamientos intensos.",
            "Mochila escolar espaciosa, con múltiples compartimentos y un diseño ergonómico para que puedas llevar libros, dispositivos y otros materiales de forma cómoda y ordenada.",
            "Lámpara de escritorio con luz LED regulable para adaptarse a tus necesidades de iluminación, ideal para estudiar o trabajar durante largas horas sin cansar la vista.",
            "Sofá de tres plazas con un diseño moderno, tapizado en tela suave y acolchado para ofrecerte la máxima comodidad al descansar o ver una película.",
            "Mesa de comedor de madera maciza, con un diseño elegante y sencillo que encaja perfectamente en cualquier estilo de decoración, ideal para reuniones familiares.",
            "Silla ergonómica para oficina, con respaldo ajustable, soporte lumbar y asiento acolchado para mejorar tu postura y comodidad durante largas jornadas de trabajo.",
            "Juego de sábanas de alta calidad, suaves al tacto y resistentes, disponibles en varios colores y tamaños para que tu cama siempre luzca perfecta.",
            "Cafetera espresso con un diseño compacto, fácil de usar y con la capacidad de preparar cafés deliciosos con una crema perfecta, ideal para los amantes del café.",
            "Batidora de mano con múltiples velocidades, ideal para preparar batidos, salsas o purés de forma rápida y eficiente, con un diseño cómodo para su uso diario.",
            "Olla a presión de acero inoxidable, con capacidad para cocinar grandes cantidades de comida en menos tiempo, perfecta para preparar guisos y sopas.",
            "Set de cuchillos de cocina con mangos ergonómicos, ideales para cortar con precisión todo tipo de alimentos, desde verduras hasta carnes, asegurando durabilidad y seguridad.",
            "Tabla de cortar de bambú, resistente y ecológica, con una superficie suave para mantener los cuchillos afilados mientras preparas tus recetas favoritas.",
            "Botella de agua reutilizable, fabricada en acero inoxidable, manteniendo la temperatura de tus bebidas por horas, perfecta para el gimnasio o llevar a cualquier parte.",
            "Mochila para senderismo con compartimentos múltiples, hecha con materiales resistentes al agua, diseñada para llevar todo lo necesario para una caminata o excursión larga.",
            "Bicicleta de montaña con suspensión total, neumáticos de gran agarre y un diseño robusto para disfrutar de rutas de montaña con máxima comodidad y seguridad.",
            "Pelota de fútbol de alta calidad, con una excelente resistencia al desgaste, ideal para entrenamientos o partidos entre amigos.",
            "Juego de pesas de diferentes tamaños, con un diseño compacto y fácil de almacenar, perfectas para mejorar tu fuerza y resistencia en casa.",
            "Colchón viscoelástico que se adapta perfectamente a la forma de tu cuerpo, proporcionando un descanso profundo y cómodo durante toda la noche.",
            "Libro de recetas con una amplia variedad de platos saludables y fáciles de preparar, ideal para quienes buscan llevar una alimentación balanceada.",
            "Juego de toallas suaves y absorbentes, fabricadas con algodón de alta calidad, ideales para el baño o la piscina, disponibles en varios colores.",
            "Cepillo eléctrico para dientes con tecnología de vibración sónica, que limpia eficazmente y ayuda a mantener una sonrisa saludable y brillante.",
            "Protector solar SPF 50 que ofrece una protección alta contra los rayos UVA y UVB, ideal para proteger tu piel de manera efectiva durante actividades al aire libre.",
            "Frigorífico doble puerta con sistema de refrigeración eficiente, gran capacidad y diseño moderno para mantener tus alimentos frescos y organizados.",
            "Lavadora automática con múltiples programas de lavado y una gran capacidad para lavar grandes cantidades de ropa, ahorrando tiempo y energía.",
            "Horno microondas con función de grill, ideal para calentar, cocinar o dorar alimentos rápidamente, con una potencia adecuada para todo tipo de platos.",
            "Consola de videojuegos de última generación, con gráficos impresionantes, juegos exclusivos y una experiencia de juego fluida y sin interrupciones.",
            "Videocámara de acción resistente al agua, perfecta para capturar tus aventuras al aire libre, con calidad de grabación 4K y estabilización de imagen.",
            "Set de pinceles para pintura, con una variedad de tamaños y tipos de cerdas, ideal tanto para principiantes como para artistas experimentados.",
            "Cuaderno de notas ecológico con papel reciclado, ideal para tomar apuntes o dibujar, con una encuadernación resistente que asegura su durabilidad.",
            "Bolígrafo de gel de tinta fluida, con un diseño cómodo y elegante, ideal para escribir con suavidad y precisión en cualquier tipo de papel.",
            "Caja de herramientas con un completo set de destornilladores, llaves y otros utensilios esenciales para realizar reparaciones o proyectos de bricolaje en casa.",
            "Taladro eléctrico de alta potencia, con múltiples velocidades y una variedad de brocas, ideal para perforar madera, metal o paredes con facilidad.",
            "Juego de mesa para niños con piezas grandes y coloridas, ideal para fomentar la creatividad y el trabajo en equipo mientras se divierten.",
            "Pack de alimentos orgánicos que incluye una variedad de productos frescos y naturales, perfectos para quienes prefieren llevar una dieta saludable y libre de químicos.",
            "Chocolates artesanales elaborados con cacao de alta calidad, con diferentes sabores y texturas, perfectos para regalar o disfrutar en cualquier momento.",
            "Bolsa de frutos secos que contiene una mezcla de almendras, nueces y avellanas, ideal para un snack saludable y lleno de energía.",
            "Botella de vino tinto de una cosecha seleccionada, con un sabor suave y afrutado, perfecta para acompañar una cena especial.",
            "Kit de jardinería que incluye herramientas esenciales como pala, rastrillo y guantes, ideal para quienes disfrutan del cuidado de plantas y flores en el hogar.",
            "Casco para bicicleta de alta seguridad, con ventilación adecuada y un diseño cómodo, imprescindible para proteger tu cabeza durante tus recorridos en bici.",
            "Maleta de viaje resistente, con ruedas multidireccionales y un compartimento principal amplio para organizar todo lo necesario para tus viajes.",
            "Perfume floral con una fragancia suave y femenina, ideal para usar durante el día o en ocasiones especiales, con una larga duración.",
            "Ropa interior térmica perfecta para mantenerte cálido en climas fríos, fabricada con materiales suaves y cómodos que se adaptan a tu cuerpo.",
            "Iphone 13 Pro MAX 255GB de almacenamiento"
        ];

        $cantidad = 30;

        
        for ($i = 0; $i < $cantidad; $i++) {
            $prodID = $faker->numberBetween(1, 50);
            DB::table("productos")->insert([
                "subcategoria_id" => $faker->numberBetween(1, 105),
                "comercio_id" => $faker->numberBetween(8, 12),
                "nombre" => $productos[$prodID],
                "descripcion" => $descripciones[$prodID],
                "precio" => $faker->randomFloat(2, 5, 1000),
                "visible" => $faker->numberBetween(0,1)
            ]);
        }
    }
}
