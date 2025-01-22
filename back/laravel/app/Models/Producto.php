<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Producto extends Model {
        use HasFactory;

        protected $table = 'productos';
        
        protected $fillable = [
            'id_categoria_concreta',
            'id_comercio',
            'nombre',
            'descripcion',
            'precio',
            'imagenes',
        ];

        public function categoriaConcreta() {
            return $this->belongsTo(CategoriaConcreta::class, 'id_categoria_concreta');
        }

        public function comercio() {
            return $this->belongsTo(Comercio::class, 'id_comercio');
        }

        public function getImagenesAttribute($value) {
            return json_decode($value, true);
        }

        public function setImagenesAttribute($value) {
            $this->attributes['imagenes'] = json_encode($value);
        }
    }