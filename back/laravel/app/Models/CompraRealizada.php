<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CompraRealizada extends Model {
        use HasFactory;

        protected $table = 'compras_realizadas';
        protected $fillable = [
            'id',
            'id_cliente',
            'fecha',
            'estado',
            'precio_total',
            'tipo_envio'
        ];

        public function cliente() {
            return $this->belongsTo(Cliente::class, 'id_cliente');
        }

        public function productosCompra() {
            return $this->hasMany(ProductoCompra::class, 'id_compra');
        }
    }