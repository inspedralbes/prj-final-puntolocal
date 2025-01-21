<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class HorarioLocal extends Model {
        protected $table = 'horario_locals';

        protected $fillable = [
            'id_comercio',
            'dia',
            'hora_apertura',
            'hora_cierre',
        ];

        public function comercio() {
            return $this->belongsTo(Comercio::class, 'id_comercio');
        }
    }