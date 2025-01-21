<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('categoria_concreta_id');
            $table->foreign('categoria_concreta_id')->references('id')->on('categoria_concretas')->onDelete('cascade');
            
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer("stock_general");
            $table->float("precio");

            $table->unsignedBigInteger('id_comercio');
            $table->foreign('id_comercio')->references('id')->on('comercio')->onDelete('cascade');

            $table->string('color')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
