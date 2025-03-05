<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name', // Nombre del contacto
        'email', // Correo electrónico
        'phone', // Número de teléfono (opcional)
        'notes', // Notas adicionales (opcional)
        'user_id', // Clave foránea para relacionar con el usuario
    ];

    // Relación con users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
