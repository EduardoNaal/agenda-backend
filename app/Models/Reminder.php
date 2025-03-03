<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'reminder_time', 'sent',
    ];

    // Relación con eventos
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
