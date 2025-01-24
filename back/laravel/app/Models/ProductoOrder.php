<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductoOrder extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'producto_id',
        'cantidad',
        'total'
    ];

    public function compra() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
