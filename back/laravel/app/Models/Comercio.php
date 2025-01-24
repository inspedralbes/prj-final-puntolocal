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
            'calle_num',
            'ciudad',
            'provincia',
            'cp',
            'categoria_id',
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