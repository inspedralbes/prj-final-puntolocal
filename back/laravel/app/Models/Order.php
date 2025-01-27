<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Order extends Model {
        protected $fillable = [
            'cliente_id',
            'fecha',
            'estado',
            'total',
            'tipo_envio'
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
    }