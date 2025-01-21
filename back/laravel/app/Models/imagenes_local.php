<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class imagenes_local extends Model{
        use HasFactory;

        protected $table = 'categorias_generales';

        protected $fillable = [
            'id',
            'id_comercio',
            'ruta',
        ];

        public function comercio() {
            return $this->belongsTo(Comercio::class, 'id_comercio');
        }
    }