<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Producto extends Model {
        use HasFactory;

        protected $table = 'productos';
        protected $fillable = [
            'id',
            'id_categoria_concreta',
            'id_comercio',
            'nombre',
            'descripcion',
            'precio',
            'imagenes'
        ];

        public function categoriaConcreta() {
            return $this->belongsTo(CategoriaConcreta::class, 'id_categoria_concreta');
        }

        public function comercio() {
            return $this->belongsTo(Comercio::class, 'id_comercio');
        }
    }