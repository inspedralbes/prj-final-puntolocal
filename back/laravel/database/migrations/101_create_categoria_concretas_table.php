<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateCategoriaConcretaTable extends Migration {
        public function up() {
            Schema::create('categorias_concretas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_categoria_general');
                $table->string('nombre');
                $table->timestamps();

                $table->foreign('id_categoria_general')->references('id')->on('categorias_generales')->onDelete('cascade');
            });
        }

        public function down() {
            Schema::dropIfExists('categorias_concretas');
        }
    }