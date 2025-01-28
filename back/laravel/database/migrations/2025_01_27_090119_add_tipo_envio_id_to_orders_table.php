<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('tipo_envio_id')
                    ->nullable()
                    ->constrained('tipo_envios')
                    ->onDelete('set null');
            });
        }

        public function down(): void {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['tipo_envio_id']);
                $table->dropColumn('tipo_envio_id');
            });
        }
    };