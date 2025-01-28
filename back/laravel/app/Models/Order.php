<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Order extends Model {
        protected $fillable = [
            'cliente_id',
            'fecha',
            'total',
            'tipo_envio',
            'estat_id',
        ];

        public function cliente() {
            return $this->belongsTo(Cliente::class, 'cliente_id');
        }

        public function productosCompra() {
            return $this->hasMany(ProductoOrder::class, 'order_id');
        }

        public function tipoEnvio() {
            return $this->belongsTo(TipoEnvio::class, 'tipo_envio_id');
        }

        public function estatCompra() {
            return $this->belongsTo(EstatCompra::class, 'estat_id');
        }
    }