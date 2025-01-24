<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('comercios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('phone', 15)->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('calle_num');
            $table->string('ciudad');
            $table->string('provincia');
            $table->string('cp');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');

            $table->text('descripcion');
            $table->boolean('gestion_stock');
            $table->float('puntaje_medio');
            $table->json('imagenes')->nullable();
            $table->json('horario')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('comercios');
    }
};