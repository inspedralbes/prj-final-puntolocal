<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('categoria_concretas', function (Blueprint $table) {
                $table->id();
                $table->string('categoria');
                $table->timestamps();
            });
        }

        public function down(): void {
            Schema::dropIfExists('categoria_concretas');
        }
    };