<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up() {
            Schema::create('productos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_categoria_concreta');
                $table->unsignedBigInteger('id_comercio');
                $table->string('nombre');
                $table->text('descripcion');
                $table->float('precio');
                $table->json('imagenes')->nullable();
                $table->timestamps();

                $table->foreign('id_categoria_concreta')->references('id')->on('categorias_concretas')->onDelete('cascade');
                $table->foreign('id_comercio')->references('id')->on('comercios')->onDelete('cascade');
            });
        }

        public function down() {
            Schema::dropIfExists('productos');
        }
    };