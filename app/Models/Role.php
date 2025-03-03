<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación con contactos (usuarios)
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
