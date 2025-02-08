<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Order extends Model {
        protected $fillable = [
            'cliente_id',
            'total',
            'tipo',
            'estat',
        ];

        public function cliente() {
            return $this->belongsTo(Cliente::class, 'cliente_id');
        }

        public function tipoEnvio() {
            return $this->belongsTo(TipoEnvio::class, 'tipo');
        }

        public function estatCompra() {
            return $this->belongsTo(EstatCompra::class, 'estat');
        }

        public function orderComercios() {
            return $this->hasMany(OrderComercio::class, 'order_id');
        }
    }