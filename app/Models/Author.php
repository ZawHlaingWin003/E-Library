<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
        'profile'
    ];

    public function getProfileAttribute($value)
    {
        return asset("storage/authors/$value");
    }
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
