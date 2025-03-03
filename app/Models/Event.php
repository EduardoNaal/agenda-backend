<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_time', 'end_time', 'contact_id',
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
