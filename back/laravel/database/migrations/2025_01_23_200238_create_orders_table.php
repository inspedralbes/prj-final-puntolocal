<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cliente_id');
                $table->dateTime('fecha');
                $table->float('total');
                $table->integer('tipo_envio');
                $table->unsignedBigInteger('estat_id')->nullable();
                $table->timestamps();

                $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
                $table->foreign('estat_id')->references('id')->on('estat_compras')->onDelete('set null');
            });
        }

        public function down(): void {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['estat_id']);
                $table->dropForeign(['cliente_id']);
            });
            Schema::dropIfExists('orders');
        }
    };