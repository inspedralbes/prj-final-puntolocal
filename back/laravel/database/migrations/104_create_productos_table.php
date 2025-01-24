<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up() {
            Schema::create('productos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('subcategoria_id');
                $table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onDelete('cascade');
                $table->unsignedBigInteger('comercio_id');
                $table->foreign('comercio_id')->references('id')->on('comercios')->onDelete('cascade');
                $table->string('nombre');
                $table->text('descripcion');
                $table->float('precio');
                $table->integer('stock')->nullable();
                $table->json('imagenes')->nullable();
            });
        }

        public function down() {
            Schema::dropIfExists('productos');
        }
    };

    // 1|jV8Z1AinmzEGnygq1VFhfHhkZ23o3sJqcls2AWnYa8f5e886