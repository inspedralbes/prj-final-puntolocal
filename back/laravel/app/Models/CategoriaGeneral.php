<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CategoriaGeneral extends Model {
        use HasFactory;

        protected $table = 'categorias_generales';

        protected $fillable = [
            'categoria',
        ];

        public function categoriasConcretas() {
            return $this->hasMany(CategoriaConcreta::class, 'id_categoria_general');
        }

        public function comercios() {
            return $this->hasMany(Comercio::class, 'categoria_general_id');
        }
    }