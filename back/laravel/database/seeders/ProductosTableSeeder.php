<?php

namespace Database\Seeders;

use App\Models\Producto;
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
            // Boutique Castelldefels - Indumentaria
            ["nombre" => "Vestido de fiesta", "comercio_id" => 1, "descripcion" => "Vestido elegante ideal para eventos formales.", "subcategoria_id" => 5, "precio" => 150, "visible" => 1, "imagen" => "productos/0gRL4ddOppHNA7oCsK2HMkUA7tqtXSBciX3mwTKl.webp"],
            ["nombre" => "Blazer de lana", "comercio_id" => 1, "descripcion" => "Blazer de corte clásico para un look sofisticado.", "subcategoria_id" => 4, "precio" => 120, "visible" => 1, "imagen" => "productos/0ZC6t0S0vpjzJaKYlQWuOODDw8Vdi8IcdWqwmI7o.webp"],
            ["nombre" => "Jeans ajustados", "comercio_id" => 1, "descripcion" => "Pantalón denim con diseño moderno y cómodo.", "subcategoria_id" => 6, "precio" => 50, "visible" => 1, "imagen" => "productos/14FzqHHsvBON3zeEKSEA9RgybToxaoqJDjoPH8AK.webp"],
            ["nombre" => "Camiseta estampada", "comercio_id" => 1, "descripcion" => "Camiseta de algodón con estampado original.", "subcategoria_id" => 2, "precio" => 10, "visible" => 1, "imagen" => "productos/1Ab2RpkRkZQobJRGeMNPzTPVgfN4Y4UAcjbc3Hv4.webp"],
            ["nombre" => "Abrigo de invierno", "comercio_id" => 1, "descripcion" => "Abrigo grueso con forro térmico para el frío.", "subcategoria_id" => 3, "precio" => 20, "visible" => 1, "imagen" => "productos/1p9J2NZzVrtUuTreRFxS2WCvHtwY8ILJ4osSl0K5.webp"],

            // Marina Moda - Indumentaria
            ["nombre" => "Falda plisada", "comercio_id" => 2, "descripcion" => "Falda midi con pliegues elegantes.", "subcategoria_id" => 3, "precio" => 20, "visible" => 1, "imagen" => "productos/2CSKvWFh8FZHpsmrCzsOnj13IUOuTmHVeFl6twKH.webp"],
            ["nombre" => "Sudadera oversize", "comercio_id" => 2, "descripcion" => "Sudadera cómoda y abrigada para el día a día.", "subcategoria_id" => 2, "precio" => 55, "visible" => 1, "imagen" => "productos/2CXmuJbKTyWlSUIofB5JUKwraD9wQrVySqa5ZlP0.webp"],
            ["nombre" => "Zapatillas urbanas", "comercio_id" => 2, "descripcion" => "Calzado deportivo con diseño moderno.", "subcategoria_id" => 2, "precio" => 38.99, "visible" => 1, "imagen" => "productos/2OUuM9jC1Oor14SbPjBDNNAJHnrbMgUySf8yrH69.webp"],
            ["nombre" => "Top de encaje", "comercio_id" => 2, "descripcion" => "Blusa con detalles en encaje, perfecta para ocasiones especiales.", "subcategoria_id" => 5, "precio" => 26.99, "visible" => 1, "imagen" => "productos/2RqzfYzj2d2RWPp3R5JSgkV5372LQChzXAOQXxHv.webp"],
            ["nombre" => "Chaqueta vaquera", "comercio_id" => 2, "descripcion" => "Chaqueta denim de corte clásico.", "subcategoria_id" => 7, "precio" => 99.99, "visible" => 1, "imagen" => "productos/39Prq1hS04MACstoiSCBoBv8Emyu4gh5MhuljjKf.webp"],

            // Tech & More - Tecnología
            ["nombre" => "Smartphone 5G", "comercio_id" => 3, "descripcion" => "Teléfono móvil con conectividad 5G y pantalla OLED.", "subcategoria_id" => 8, "precio" => 350, "visible" => 1, "imagen" => "productos/3VKJo5NvR8M6F4q4W4CdGTyA3req4xDCxZpGcVBO.webp"],
            ["nombre" => "Auriculares Bluetooth", "comercio_id" => 3, "descripcion" => "Auriculares inalámbricos con cancelación de ruido.", "subcategoria_id" => 9, "precio" => 9.99, "visible" => 1, "imagen" => "productos/4AbAj8dz95IDyFWFogFFcmEJgRjm8Zf0K2Z8cO3p.webp"],
            ["nombre" => "Laptop ultraligera", "comercio_id" => 3, "descripcion" => "Ordenador portátil de última generación.", "subcategoria_id" => 10, "precio" => 15, "visible" => 1, "imagen" => "productos/4CNaQiH5QYX4SPq65XdCXnpNmWM957IcnenepX10.webp"],
            ["nombre" => "Mouse gamer RGB", "comercio_id" => 3, "descripcion" => "Ratón ergonómico con iluminación LED.", "subcategoria_id" => 11, "precio" => 35, "visible" => 1, "imagen" => "productos/4pzDwiJHJmMQMIjgkI9IfgBbI4Y18vcuIWobS6n0.webp"],
            ["nombre" => "Cámara de seguridad", "comercio_id" => 3, "descripcion" => "Cámara IP con detección de movimiento.", "subcategoria_id" => 12, "precio" => 40, "visible" => 1, "imagen" => "productos/5oD290nQed2XPlrag5OaplvNudji3RtiG1LdIDDE.webp"],

            // Ferretería El Faro - Ferretería
            ["nombre" => "Taladro percutor", "comercio_id" => 4, "descripcion" => "Taladro eléctrico con múltiples velocidades.", "subcategoria_id" => 36, "precio" => 38.99, "visible" => 1, "imagen" => "productos/5S4Rvg5gcNnUXtJsT36Xs6yhyewp1Oo3D4vANnZ4.webp"],
            ["nombre" => "Martillo de acero", "comercio_id" => 4, "descripcion" => "Martillo de uso profesional con mango ergonómico.", "subcategoria_id" => 37, "precio" => 45, "visible" => 1, "imagen" => "productos/78bU1vy54aolZADScMROo14tbMdFIxwl71OwbKnZ.webp"],
            ["nombre" => "Caja de herramientas", "comercio_id" => 4, "descripcion" => "Kit completo con destornilladores y llaves.", "subcategoria_id" => 38, "precio" => 40, "visible" => 1, "imagen" => "productos/7MN8YUcPfetVUEmOpH5PeUFU8NPWE1WsZ9RHIeLi.webp"],
            ["nombre" => "Sierra eléctrica", "comercio_id" => 4, "descripcion" => "Sierra de corte rápido para madera y metal.", "subcategoria_id" => 39, "precio" => 30, "visible" => 1, "imagen" => "productos/8i1cRdESdTSI5P07GY9XAqAeoOmjmuOFdzqiNFUP.webp"],
            ["nombre" => "Llave inglesa ajustable", "comercio_id" => 4, "descripcion" => "Llave de precisión con agarre antideslizante.", "subcategoria_id" => 40, "precio" => 15.99, "visible" => 1, "imagen" => "productos/9mqhls81DalLC2F5LR5abvdc2CICcJt3W9kvfjWF.webp"],

            // Belleza Urbana - Cosméticos
            ["nombre" => "Base líquida mate", "comercio_id" => 5, "descripcion" => "Base de maquillaje con acabado natural.", "subcategoria_id" => 28, "precio" => 100, "visible" => 1, "imagen" => "productos/9sPQutfjtuTg57xvSgqqaw44wReSnQrMAo6PV0wF.webp"],
            ["nombre" => "Paleta de sombras", "comercio_id" => 5, "descripcion" => "Colores vibrantes para maquillaje profesional.", "subcategoria_id" => 27, "precio" => 100, "visible" => 1, "imagen" => "productos/afYBh5nMe9SBsFKj6qdW4Fm7jMF4TTuy5dlc9vaY.webp"],
            ["nombre" => "Labial rojo intenso", "comercio_id" => 5, "descripcion" => "Bálsamo labial de larga duración.", "subcategoria_id" => 26, "precio" => 100, "visible" => 1, "imagen" => "productos/an5VafUNpB1g1Ae0KTcmw2AYwNpShJdVVPPyTMSR.webp"],
            ["nombre" => "Delineador waterproof", "comercio_id" => 5, "descripcion" => "Delineador resistente al agua con punta fina.", "subcategoria_id" => 25, "precio" => 100, "visible" => 1, "imagen" => "productos/aRhhLyhTitv8Ub5quYHlFotqaOXDemej8WWf6tG3.webp"],
            ["nombre" => "Crema facial hidratante", "comercio_id" => 5, "descripcion" => "Hidratante con ácido hialurónico y SPF 30.", "subcategoria_id" => 24, "precio" => 100, "visible" => 1, "imagen" => "productos/aT67PrZoivn1iI6WihtCNZ9OaVbqtXebBDiTPbDz.webp"],

            // Repuestos Auto Express - Repuestos
            ["nombre" => "Filtro de aceite", "comercio_id" => 6, "descripcion" => "Filtro de alto rendimiento para motores.", "subcategoria_id" => 14, "precio" => 29.99, "visible" => 1, "imagen" => "productos/axGPALK5WEZuJKj3wXUAeiUAT149QWTv2NsXzVhF.webp"],
            ["nombre" => "Juego de bujías", "comercio_id" => 6, "descripcion" => "Bujías de encendido de alta durabilidad.", "subcategoria_id" => 13, "precio" => 35, "visible" => 1, "imagen" => "productos/azgIoywZc3PSRVuTtaQTivAa9fsAKJoi7RtfUHZQ.webp"],
            ["nombre" => "Batería 12V", "comercio_id" => 6, "descripcion" => "Batería de coche con gran capacidad.", "subcategoria_id" => 12, "precio" => 55, "visible" => 1, "imagen" => "productos/BLvRevduZ2yPnRZhLgtkWEkBUmBFg9kQFMh332bh.webp"],
            ["nombre" => "Aceite sintético", "comercio_id" => 6, "descripcion" => "Lubricante para motor de alto rendimiento.", "subcategoria_id" => 11, "precio" => 130, "visible" => 1, "imagen" => "productos/bm0PhGP2g6j2ts3UFQJSnNduzJDB0nN33lfLU5v7.webp"],
            ["nombre" => "Pastillas de freno", "comercio_id" => 6, "descripcion" => "Juego de frenos de alta seguridad.", "subcategoria_id" => 10, "precio" => 150, "visible" => 1, "imagen" => "productos/BnTfIOpBpQSfGe1jhUPIsTswMHjMZLLn1ivzLA7Q.webp"],

            // Home & Decor Hub - Hogar
            ["nombre" => "Juego de sábanas", "comercio_id" => 7, "descripcion" => "Sábanas de algodón suave y fresco.", "subcategoria_id" => 15, "precio" => 120, "visible" => 1, "imagen" => "productos/bOivj3yiEyBoEpoRuztwo8ERcLPw7ce8g3C7BS0r.webp"],
            ["nombre" => "Cafetera de acero", "comercio_id" => 7, "descripcion" => "Cafetera con sistema antigoteo y filtro permanente.", "subcategoria_id" => 16, "precio" => 95, "visible" => 1, "imagen" => "productos/BS6MYy0RAPRhvKHiJphEaLI6yQkXq6y3ojjQq55d.webp"],
            ["nombre" => "Lámpara de pie", "comercio_id" => 7, "descripcion" => "Lámpara LED con diseño moderno.", "subcategoria_id" => 17, "precio" => 85, "visible" => 1, "imagen" => "productos/bWSboeXiubV7QZnkMIwlwRcy60GX9FYGsQF9x3Ec.webp"],
            ["nombre" => "Sofá reclinable", "comercio_id" => 7, "descripcion" => "Sofá cómodo con tapizado premium.", "subcategoria_id" => 18, "precio" => 75, "visible" => 1, "imagen" => "productos/CEjjkFaqhUX8vKVB9ZjLrs2bmieDRd2LskaCLlyd.jpg"],
            ["nombre" => "Aspiradora ciclónica", "comercio_id" => 7, "descripcion" => "Aspiradora sin bolsa con alto poder de succión.", "subcategoria_id" => 19, "precio" => 70, "visible" => 1, "imagen" => "productos/ChR2V4l0QWqLABB6tydmE4NB0X8yWOHsog8SPCk9.webp"],

            // Accesorios Chic - Accesorios
            ["nombre" => "Bolso de cuero", "comercio_id" => 8, "descripcion" => "Bolso elegante de piel auténtica.", "subcategoria_id" => 84, "precio" => 60, "visible" => 1, "imagen" => "productos/csqdKLaAHUuyEJ3vifqSpGwdwOR6uX37btEKsZZt.webp"],
            ["nombre" => "Gafas de sol", "comercio_id" => 8, "descripcion" => "Lentes polarizados con protección UV.", "subcategoria_id" => 83, "precio" => 50, "visible" => 1, "imagen" => "productos/cXX44UxACWhO93wwqp8CVNRpjMyQ5LA7yUgJazRW.webp"],
            ["nombre" => "Reloj minimalista", "comercio_id" => 8, "descripcion" => "Reloj con correa de cuero y esfera clásica.", "subcategoria_id" => 82, "precio" => 40, "visible" => 1, "imagen" => "productos/DEiAekU93RpKGhz8NoKT37EG8EV5jmnz1bsWO15p.webp"],
            ["nombre" => "Collar de plata", "comercio_id" => 8, "descripcion" => "Colgante de plata de ley con diseño exclusivo.", "subcategoria_id" => 81, "precio" => 30, "visible" => 1, "imagen" => "productos/DI4C5cjGcVdLdr2Qx190hBU8xitZc4gOQ5G5fcyd.webp"],
            ["nombre" => "Pulsera con charms", "comercio_id" => 8, "descripcion" => "Pulsera ajustable con dijes intercambiables.", "subcategoria_id" => 80, "precio" => 20, "visible" => 1, "imagen" => "productos/DiUBCNheoUh8aAEPnR9D93y4FMWO8u3bacNDIp7s.webp"],

            // Electrónica Viva - Tecnología
            ["nombre" => "Tablet de 10 pulgadas", "comercio_id" => 9, "descripcion" => "Pantalla táctil HD con procesador rápido.", "subcategoria_id" => 8, "precio" => 14.99, "visible" => 1, "imagen" => "productos/dJnH4CKIVuJHNnoV5GYr24fm3xuFBhjxNvJd90xQ.webp"],
            ["nombre" => "Barra de sonido", "comercio_id" => 9, "descripcion" => "Sonido envolvente con conexión Bluetooth.", "subcategoria_id" => 9, "precio" => 120, "visible" => 1, "imagen" => "productos/djXobntQ1f60MN7UWQqW7tn6B8YZBN38iclmbRbf.webp"],
            ["nombre" => "Cargador inalámbrico", "comercio_id" => 9, "descripcion" => "Carga rápida para dispositivos móviles.", "subcategoria_id" => 10, "precio" => 78.99, "visible" => 1, "imagen" => "productos/Dvaj2z8KbTHWXlpTDcXAS9NKXuUHyZ5xAF7tYhHd.webp"],
            ["nombre" => "Router WiFi 6", "comercio_id" => 9, "descripcion" => "Internet de alta velocidad con baja latencia.", "subcategoria_id" => 11, "precio" => 35, "visible" => 1, "imagen" => "productos/eihyQTPhnFhE4hYGYRGQbNVeeaxBoQTgB1DT88q1.webp"],
            ["nombre" => "Disco SSD 1TB", "comercio_id" => 9, "descripcion" => "Almacenamiento rápido para ordenadores.", "subcategoria_id" => 12, "precio" => 120.50, "visible" => 1, "imagen" => "productos/FaMxGSAi3cSet60dypGtnKBjXvxPElFjthBhYwyJ.webp"],

            // Cosmética Natural - Cosméticos
            ["nombre" => "Jabón artesanal", "comercio_id" => 10, "descripcion" => "Elaborado con ingredientes naturales.", "subcategoria_id" => 22, "precio" => 35, "visible" => 1, "imagen" => "productos/fei292MLfdX5oj99VX6cxiEncLAOGqm1omE4Lk79.webp"],
            ["nombre" => "Aceite de argán", "comercio_id" => 10, "descripcion" => "Aceite orgánico para piel y cabello.", "subcategoria_id" => 23, "precio" => 89.99, "visible" => 1, "imagen" => "productos/GlL55FfbkJkBSeGCC3lNgyZ8Nxw7EqIMbAB5inj1.webp"],
            ["nombre" => "Mascarilla facial", "comercio_id" => 10, "descripcion" => "Tratamiento hidratante para todo tipo de piel.", "subcategoria_id" => 24, "precio" => 65, "visible" => 1, "imagen" => "productos/Gq54vjp4Ukw4SDzQa3Otu6bwn9tOx1xsF9ygztsx.webp"],
            ["nombre" => "Perfume vegano", "comercio_id" => 10, "descripcion" => "Fragancia sin químicos dañinos.", "subcategoria_id" => 25, "precio" => 20, "visible" => 1, "imagen" => "productos/GR9NpWThO3s4T1whvH8TMw39AyZVhQr4Cj6ZkOe5.webp"],
            ["nombre" => "Shampoo sólido", "comercio_id" => 10, "descripcion" => "Fórmula ecológica sin sulfatos.", "subcategoria_id" => 26, "precio" => 35.99, "visible" => 1, "imagen" => "productos/h3tEHd7DRR6lJZu0qwj6LHTfoYJQBAOHcIbtu2cc.webp"],
        ];

        Producto::insert($productos);
    }
}