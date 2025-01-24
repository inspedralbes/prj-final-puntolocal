<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Comercio extends Model {
        use HasFactory;

        protected $fillable = [
            'nombre',
            'phone',
            'email',
            'email_verified_at',
            'calle_num',
            'ciudad',
            'provincia',
            'cp',
            // 'num_planta',
            // 'num_puerta',
            'categoria_id',
            'idUser',
            'descripcion',
            'gestion_stock',
            'puntaje_medio',
            'imagenes',
            'horario',
        ];

        public function categoria() {
            return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
        }
    }