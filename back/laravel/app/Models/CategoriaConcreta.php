<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CategoriaConcreta extends Model {
        use HasFactory;

        protected $table = 'categorias_concretas';
        protected $fillable = [
            'id',
            'id_categoria_general',
            'nombre'
        ];

        public function categoriaGeneral() {
            return $this->belongsTo(CategoriaGeneral::class, 'id_categoria_general');
        }

        public function productos() {
            return $this->hasMany(Producto::class, 'id_categoria_concreta');
        }
    }