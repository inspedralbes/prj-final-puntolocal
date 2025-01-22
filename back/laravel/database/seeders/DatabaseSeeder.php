<?php
    namespace Database\Seeders;

    use App\Models\User;
    // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Database\Seeders\CategoriasConcretasSeeder;

    class DatabaseSeeder extends Seeder {
        public function run() {
            $this->call(CategoriasConcretasSeeder::class);
        }
        
    }