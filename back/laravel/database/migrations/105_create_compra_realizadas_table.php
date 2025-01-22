<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up() {
            Schema::create('compras_realizadas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_cliente');
                $table->dateTime('fecha');
                $table->integer('estado'); // 0 = recibido, 1 = enviado, etc.
                $table->float('precio_total');
                $table->string('tipo_envio', 50);
                $table->timestamps();

                $table->foreign('id_cliente')->references('id')->on('cliente')->onDelete('cascade');
            });
        }

        public function down() {
            Schema::dropIfExists('compras_realizadas');
        }
    };