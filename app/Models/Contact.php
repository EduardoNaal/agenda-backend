<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'notes',
        'user_id',
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
