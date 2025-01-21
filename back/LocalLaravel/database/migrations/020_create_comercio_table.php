<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('comercio', function (Blueprint $table) {
                $table->id();
                $table->string('name');                             // Nombre del comercio

                $table->string('email')->unique();                  // Email
                $table->timestamp('email_verified_at')->nullable(); // Verificación de Email

                $table->string('phone', 15);                        // Teléfono
                $table->timestamp('phone_verified_at')->nullable(); // Verificación de Teléfono

                $table->string('password');                         // Contraseña
                $table->string('street_address');                   // Calle y número
                $table->string('ciudad');                           // Ciudad
                $table->string('provincia');                        // Provincia
                $table->integer('codigo_postal');                   // Código postal
                $table->integer('numero_planta')->nullable();       // Número de la planta
                $table->integer('numero_puerta')->nullable();       // Número puerta

                $table->unsignedBigInteger('categorias_generales');
                $table->foreign('categorias_generales')->references('id')->on('categorias_generales')->onDelete('cascade');

                $table->string('descripcion');                      // Descripción del comercio
                $table->boolean('gestion_stock');                   // ¿Gestiona stock?
                $table->float('puntaje_medio');                     // Puntaje medio
                $table->timestamps();
            });
        }

        public function down(): void {
            Schema::dropIfExists('comercio');
        }
    };