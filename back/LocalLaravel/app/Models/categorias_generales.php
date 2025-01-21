<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CategoriaGeneral extends Model {
        use HasFactory;

        protected $table = 'categorias_generales';

        protected $fillable = [
            'id',
            'categoria',
        ];

        public function clientes() {
            return $this->hasMany(Cliente::class, 'categorias_generales');
        }

        public function comercios() {
            return $this->hasMany(Comercio::class, 'categorias_generales');
        }
    }