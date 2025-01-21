<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateProductosCompraTable extends Migration {
        public function up() {
            Schema::create('productos_compra', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_compra');
                $table->unsignedBigInteger('id_producto');
                $table->integer('cantidad');
                $table->float('precio_total');
                $table->timestamps();

                $table->foreign('id_compra')->references('id')->on('compras_realizadas')->onDelete('cascade');
                $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
            });
        }

        public function down() {
            Schema::dropIfExists('productos_compra');
        }
    }