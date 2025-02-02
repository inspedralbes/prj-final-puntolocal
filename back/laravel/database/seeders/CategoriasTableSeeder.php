<?php
    namespace Database\Seeders;

    use App\Models\Categoria;
    use Illuminate\Database\Seeder;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;

    class CategoriasTableSeeder extends Seeder {
        public function run(): void {
            $categorias = [
                ["name" => "Indumentaria",          "imagenes" => "https://imgs.search.brave.com/M-A8CIRtfdLCtUcNf5sl877CfmQ1ZyHLFv_2mcXBIFE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/YWx2YXJvbW9saW5l/ci5jb20vNDU2Mzgt/aG9tZV9kZWZhdWx0/L2NvcnRlLWNoYWxl/Y28tc2FuLWhlcmFs/ZG8tc2VkYS0zMjVt/LmpwZw"],
                ["name" => "Tecnología",            "imagenes" => "https://imgs.search.brave.com/ki34G_CVxS6zzWethgu-rCrBpQhMX2pUbsyTLMGl0Mw/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4t/aWNvbnMtcG5nLmZy/ZWVwaWsuY29tLzI1/Ni8zNzE1LzM3MTUz/MDEucG5nP3NlbXQ9/YWlzX2h5YnJpZA"],
                ["name" => "Hogar y Decoración",    "imagenes" => "https://imgs.search.brave.com/q7qbhonc6M_C7RGo6arRWN17n3zLWH1o7PZwxWKnDDI/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4t/aWNvbnMtcG5nLmZy/ZWVwaWsuY29tLzI1/Ni8xMTY1My8xMTY1/MzU1MS5wbmc_c2Vt/dD1haXNfaHlicmlk"],
                ["name" => "Salud y Belleza",       "imagenes" => "https://imgs.search.brave.com/sybOvjH44Lzr6jtr15xVunjrqDGHOBojObKODlSJM6c/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zYWx1/ZGV4dHJlbWFkdXJh/LnNlcy5lcy9maWxl/c2Ntcy93ZWIvdXBs/b2FkZWRfaW1hZ2Vz/L21lbnUvbHVwYS1l/bmZlcm1lZGFkX3Jh/cmEucG5n"],
                ["name" => "Verdulería",            "imagenes" => "https://imgs.search.brave.com/23u8fDo6PF1mr1JQ9CvFQKht3yAQuP2K6ok7lNsOwDk/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMudmVjdGVlenku/Y29tL3N5c3RlbS9y/ZXNvdXJjZXMvdGh1/bWJuYWlscy8wNDUv/NzU3LzIwNy9zbWFs/bC9hLWNvbG9yZnVs/LWFzc29ydG1lbnQt/b2YtZnJ1aXRzLWFu/ZC12ZWdldGFibGVz/LWluY2x1ZGluZy1h/cHBsZXMtb3Jhbmdl/cy1wbmcucG5n"],
                ["name" => "Carnicerías",           "imagenes" => "https://imgs.search.brave.com/jQYxSgYlvukofj_ta15vTcr2fpmXokNXi9jI7UCyMFo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/cGl4YWJheS5jb20v/cGhvdG8vMjAxNC8x/Mi8yMS8yMy8yNS9i/YWNvbi01NzUzMzRf/XzM0MC5wbmc"],
                ["name" => "Jugueterías",           "imagenes" => "https://imgs.search.brave.com/mRncdj5ZQLUoy94fCKkD8ogU28Br-taeBcFu0dE9y1I/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly91cGxv/YWRzLnR1cmJvbG9n/by5jb20vdXBsb2Fk/cy9kZXNpZ24vcHJl/dmlld19pbWFnZS80/NzIzNzY1L3ByZXZp/ZXdfaW1hZ2UyMDI0/MDYxOC03LTE1b2Fr/dHoucG5n"],
                ["name" => "Ferreterías",           "imagenes" => "https://imgs.search.brave.com/WBHCuwgrTq1bkO6rcbQcyz5bGhuMtKSqCtR-u472eQA/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wbmcu/cG5ndHJlZS5jb20v/cG5nLWNsaXBhcnQv/MjAyMzAxMTcvb3Vy/bWlkL3BuZ3RyZWUt/bmFpbC1jbGlwcGVy/cy1zY2lzc29ycy1o/YXJkd2FyZS1hY2Nl/c3Nvcmllcy1wbmct/aW1hZ2VfNjE1OTkx/NS5wbmc"],
                ["name" => "Librerías",             "imagenes" => "https://imgs.search.brave.com/Ow8kaOXLhq7GN3Y6idozDZEGJaR2GQZuPju0UHLL17o/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wbmcu/cG5ndHJlZS5jb20v/cG5nLWNsaXBhcnQv/MjAyMjA5Mjkvb3Vy/bWlkL3BuZ3RyZWUt/bGlicmFyeS1ib29r/c2hlbGYtcG5nLWlt/YWdlXzYyMjgwNjYu/cG5n"],
                ["name" => "Farmacias",             "imagenes" => "http://imgs.search.brave.com/FJXuYv0L63NlxDj9kFB4pBi5cGk2fXIuHPELuIZ8uZI/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wbmcu/cG5ndHJlZS5jb20v/cG5nLWNsaXBhcnQv/MjAyMTEwMTQvb3Vy/bWlkL3BuZ3RyZWUt/cGhhcm1hY3ktZmxh/dC1zdHlsZS1pbGx1/c3RyYXRpb24tZmVt/YWxlLXBoYXJtYWNp/c3QtcG5nLWltYWdl/XzM5NzYzNzQucG5n"],
                ["name" => "Zapaterías",            "imagenes" => "https://imgs.search.brave.com/uWMGhmg_MmX4sC4To6bUk2vF-byKT3wa-K-6hvySRO4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wYWJs/b3NreS5jb20vY2Ru/L3Nob3AvZmlsZXMv/NDAweDYwMF9CT1RB/UzIucG5nP3Y9MTcz/MTU4Nzg5NiZ3aWR0/aD01MTQ"],
                ["name" => "Floristerías",          "imagenes" => "https://imgs.search.brave.com/uiy2C2gkn3EY18sdRbGF4fiGwbFD_GUFOGf7vC9Qa9w/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/cGl4YWJheS5jb20v/cGhvdG8vMjAxNy8w/Ni8wNC8yMy81OS93/aWxkLWZsb3dlcnMt/MjM3MjU0OF82NDAu/cG5n"],
                ["name" => "Ópticas",               "imagenes" => "https://imgs.search.brave.com/qSW-kcMxuy0dYJhi5ggBkVYWQcQxqxgy7o1S7IYbqE4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly91cGxv/YWRzLnR1cmJvbG9n/by5jb20vdXBsb2Fk/cy9kZXNpZ24vcHJl/dmlld19pbWFnZS82/ODQ2MDk4MS9wcmV2/aWV3X2ltYWdlMjAy/NDExMzAtMS1vZzU0/OXEucG5n"],
                ["name" => "Accesorios",            "imagenes" => "https://imgs.search.brave.com/rCMNMlQ0nSX9J9V6ztDr9OV-wTK-R0Uk9D07hkVIOEg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/cG5nYXJ0cy5jb20v/ZmlsZXMvNC9XYXRj/aC1TdHJhcC1QTkct/UGljdHVyZS5wbmc"],
                ["name" => "Tiendas de Mascotas",   "imagenes" => "https://imgs.search.brave.com/hOiD57G4j9rGpxVlbk6zf0F4ZAa87i0Kqu-rUtXZuo4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMudmV4ZWxzLmNv/bS9tZWRpYS91c2Vy/cy8zLzIyMzMxNi9p/c29sYXRlZC9wcmV2/aWV3L2M0MmQ5OGY2/YzdkZDYzYmE5Y2E2/NzNkMjBhMDQ5MmNl/LXRpZW5kYS1kZS1t/YXNjb3Rhcy1lZGlm/aWNpby10aWVuZGEt/cGxhbmEucG5n"],
            ];
            Categoria::insert($categorias);
        }
    }