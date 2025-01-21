<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateCategoriaGeneralsTable extends Migration {
        public function up() {
            Schema::create('categorias_generales', function (Blueprint $table) {
                $table->id();
                $table->string('categoriaID');
                $table->timestamps();
            });
        }

        public function down() {
            Schema::dropIfExists('categorias_generales');
        }
    }