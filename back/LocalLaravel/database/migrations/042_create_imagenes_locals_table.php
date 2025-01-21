<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('imagenes_locals', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger("id_comercio");
                $table->foreign("id_comercio")->references('id')->on('comercio')->onDelete('cascade');

                $table->string("ruta");
                $table->timestamps();
            });
        }

        public function down(): void {
            Schema::dropIfExists('imagenes_locals');
        }
    };