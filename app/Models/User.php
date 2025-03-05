<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', // Nombre del usuario
        'email', // Correo electrónico
        'password', // Contraseña
    ];

    protected $hidden = [
        'password', // Ocultar contraseña en las respuestas
        'remember_token', // Ocultar token de recordar sesión
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convertir a tipo datetime
            'password' => 'hashed', // Convertir contraseña a hash
        ];
    }

    // Relación con contactos
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // Verificar si el usuario es administrador
    public function isAdmin()
    {
        return $this->hasRole('admin'); // Usar hasRole de Spatie
    }
}
