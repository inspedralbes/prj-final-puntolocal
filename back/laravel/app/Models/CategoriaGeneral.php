<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CategoriaGeneral extends Model {
        use HasFactory;

        protected $fillable = [
            'id',
            'categoriaID',
        ];

        public function comercios() {
            return $this->hasMany(Comercio::class, 'categoria_general_id');
        }
    }