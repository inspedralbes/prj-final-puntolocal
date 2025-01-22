<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up() {
            Schema::create('categorias_concretas', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');

                $table->unsignedBigInteger('id_categoria_general');
                $table->foreign('id_categoria_general')->references('id')->on('categorias_generales')->onDelete('cascade');
                
                $table->timestamps();
            });
        }

        public function down() {
            Schema::dropIfExists('categorias_concretas');
        }
    };