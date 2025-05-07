<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up() {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cliente_id')->constrained('cliente')->onDelete('cascade');
                $table->unsignedInteger('rating');
                $table->text('comment')->nullable();
                $table->unsignedBigInteger('rateable_id');
                $table->string('rateable_type');
                $table->timestamps();
                $table->index(['rateable_id', 'rateable_type']);
                $table->unique(['cliente_id', 'rateable_id', 'rateable_type'], 'unique_rating_per_user');
            });
        }

        public function down() {
            Schema::dropIfExists('ratings');
        }
    };
