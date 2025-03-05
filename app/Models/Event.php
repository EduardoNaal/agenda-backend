<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // Título del evento
        'description', // Descripción del evento (opcional)
        'start_time', // Fecha y hora de inicio
        'end_time', // Fecha y hora de finalización
        'contact_id', // Clave foránea para relacionar con el contacto
    ];

    // Relación con contactos
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // Relación con recordatorios
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
