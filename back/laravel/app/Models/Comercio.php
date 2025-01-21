<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Comercio extends Model {
        use HasFactory;

        protected $fillable = [
            'id',
            'nombre',
            'phone',
            'phone_verified_at',
            'email',
            'email_verified_at',
            'password',
            'calle_num',
            'ciudad',
            'provincia',
            'cp',
            'num_planta',
            'num_puerta',
            'categoria_general_id',
            'descripcion',
            'gestion_stock',
            'puntaje_medio',
            'imagenes',
            'horario',
        ];

        public function categoriaGeneral() {
            return $this->belongsTo(CategoriaGeneral::class, 'categoria_general_id');
        }
    }