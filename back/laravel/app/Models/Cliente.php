<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens; 

    class Cliente extends Authenticatable {
        use HasFactory, Notifiable, HasApiTokens, Billable;

        protected $table = 'cliente';

        protected $fillable = [
            'name', 'apellidos', 'email', 'phone',
            'password', 'is_google_user', 'street_address', 'ciudad', 'provincia',
            'codigo_postal', 'numero_planta', 'numero_puerta', 'puntos',
        ];

        protected $hidden = [ 'password', 'remember_token', ];

        protected $casts = [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
        ];

        public function comercios() {
            return $this->hasMany(Comercio::class, 'idUser');
        }
    }