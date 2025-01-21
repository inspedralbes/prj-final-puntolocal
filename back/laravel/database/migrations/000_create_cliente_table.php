<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('cliente', function (Blueprint $table) {
                $table->id();
                $table->string('name');                             // Nombre 
                $table->string('apellidos');                        // Apellidos

                $table->string('email')->unique();                  // Email
                $table->timestamp('email_verified_at')->nullable(); // Verificación de Email

                $table->string('phone', 15)->nullable();            // Teléfono
                $table->timestamp('phone_verified_at')->nullable(); //Verificación de Telefono

                $table->string('password')->nullable();             // Contraseña
                $table->string('street_address')->nullable();       // Calle y número
                $table->string('ciudad')->nullable();               // Ciudad
                $table->string('provincia')->nullable();            // Provincia
                $table->integer('codigo_postal')->nullable();       // Código postal
                $table->integer('numero_planta')->nullable();       // Numero de la planta
                $table->integer('numero_puerta')->nullable();       // Numero puerta

                $table->integer('puntos')->nullable();

                $table->rememberToken();
                $table->timestamps();
            });
            

            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });

            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        public function down(): void {
            Schema::dropIfExists('users');
            Schema::dropIfExists('password_reset_tokens');
            Schema::dropIfExists('sessions');
        }
    };