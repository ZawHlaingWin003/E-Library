<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'author_id',
        'published_at',
        'cover',
        'pdf_file',
        'likes',
        'views'
    ];

    protected $dates = [
        'published_at'
    ];

    public function getCoverAttribute($value)
    {
        return asset("storage/books/$this->slug/covers/$value");
    }

    public function getPdfFileAttribute($value)
    {
        return asset("storage/books/$this->slug/pdf_files/$value");
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class)
            ->using(BookGenre::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}