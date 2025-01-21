<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Comercio extends Model {
        use HasFactory;

        protected $table = 'comercio';

        protected $fillable = [
            'name',
            'email',
            'phone',
            'password',
            'street_address',
            'ciudad',
            'provincia',
            'codigo_postal',
            'numero_planta',
            'numero_puerta',
            'categorias_generales',
            'descripcion',
            'gestion_stock',
            'puntaje_medio',
        ];

        public function cliente() {
            return $this->belongsTo(Cliente::class, 'id_cliente');
        }

        public function categoriaGeneral() {
            return $this->belongsTo(CategoriaGeneral::class, 'categorias_generales');
        }

        public function imagenes() {
            return $this->hasMany(ImagenLocal::class, 'id_comercio');
        }

        public function horarios() {
            return $this->hasMany(HorarioLocal::class, 'id_comercio');
        }
    }