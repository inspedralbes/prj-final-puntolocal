<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ProductoCompra extends Model {
        use HasFactory;

        protected $table = 'productos_compra';
        protected $fillable = [
            'id',
            'id_compra',
            'id_producto',
            'cantidad',
            'precio_total'
        ];

        public function compra() {
            return $this->belongsTo(CompraRealizada::class, 'id_compra');
        }

        public function producto() {
            return $this->belongsTo(Producto::class, 'id_producto');
        }
    }