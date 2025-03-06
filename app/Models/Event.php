<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // Título del evento
        'description', // Descripción del evento (opcional)
        'start_time', // Fecha y hora de inicio
        'end_time', // Fecha y hora de finalización
        'user_id', // Clave foránea para relacionar con el usuario
    ];

    // Relación con users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con recordatorios
    public function reminder()
    {
        return $this->hasMany(Reminder::class);
    }
}

