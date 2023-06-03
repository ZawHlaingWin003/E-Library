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

    // public function scopeFilter($query, $filter) //Blog::latest()->filter()
    // {
    //     $query->when($filter['search'] ?? false, function ($query, $search) {
    //         $query->where(function ($query) use ($search) {
    //             $query->where('title', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('body', 'LIKE', '%' . $search . '%');
    //         });
    //     });
    //     $query->when($filter['category'] ?? false, function ($query, $slug) {
    //         $query->whereHas('category', function ($query) use ($slug) {
    //             $query->where('slug', $slug);
    //         });
    //     });
    //     $query->when($filter['username'] ?? false, function ($query, $username) {
    //         $query->whereHas('author', function ($query) use ($username) {
    //             $query->where('username', $username);
    //         });
    //     });
    // }

    public function scopeFilter($query, $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('excerpt', 'LIKE', '%' . $search . '%')
        );

        $query->when(
            $filters['genre'] ?? false,
            function ($query, $genreId) {
                $query->whereHas('genres', function ($query) use ($genreId) {
                    $query->where('genres.id', $genreId);
                });
            }
        );

        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('id', $author)
            )
        );
    }

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
