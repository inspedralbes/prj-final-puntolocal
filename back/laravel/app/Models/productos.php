<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Producto extends Model {
        use HasFactory;

        protected $fillable = [
            'categoria_concreta_id',
            'id_comercio',
            'color',
            'nombre',
            'descripcion',
            'stock_general',
            'precio',
        ];

        public function categoriaConcreta() {
            return $this->belongsTo(CategoriaConcreta::class, 'categoria_concreta_id');
        }

        public function comercio() {
            return $this->belongsTo(Comercio::class, 'id_comercio');
        }
    }