<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // roles
    const ROLE_ADMIN = 'admin';
    const ROLE_JUGADOR = 'jugador';
    const ROLE_VISITANTE = 'visitante';
  

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // CAMBIAMOS EL ANTIGUO METODO POR ESTA PROPIEDAD.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // SUSTITUIMOS EL METODO POR UNA PROPIEDAD
    // Esto permite que:
    // Laravel convierta automáticamente email_verified_at en una instancia de Carbon (para fechas) al obtenerlo.
    // La contraseña (password) se hashee automáticamente antes de guardarse en la base de datos, gracias al nuevo tipo hashed introducido en versiones recientes.
    //
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    // Relación con el modelo `Equipo`
    public function equipo()
    {
        return $this->hasOne(Equipo::class, 'user_id');
    }
    // Método para verificar si un usuario es administrador
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Método para verificar si un usuario es jugador
    public function isJugador()
    {
        return $this->role === self::ROLE_JUGADOR;
    }

    // Método para verificar si un usuario es jugador
    public function isVisitante()
    {
        return $this->role === self::ROLE_VISITANTE;
    }
}
