<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaConcreta extends Model
{
    use HasFactory;

    protected $table = 'categoria_concretas';

    protected $fillable = [
        'id',
        'categoria',
    ];

    public function productos() {
        return $this->hasMany(Producto::class, 'categoria_concreta_id');
    }
}
