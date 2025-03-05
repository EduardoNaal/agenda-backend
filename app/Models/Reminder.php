<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', // Clave foránea para relacionar con el evento
        'reminder_time', // Fecha y hora del recordatorio
        'sent', // Indica si el recordatorio fue enviado
    ];

    // Relación con eventos
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
