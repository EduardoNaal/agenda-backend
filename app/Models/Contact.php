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
        'role_id',
    ];

    // Relación con eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    // Relación con roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
