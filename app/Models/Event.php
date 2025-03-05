<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'user_id', // Ahora está relacionado con el usuario
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

