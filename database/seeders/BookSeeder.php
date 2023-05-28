<?php

namespace Database\Seeders;

use App\Models\Book;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [
            'Global Economic Prospects',
            'The Invisible Man',
            'Deep Trade Aggrements',
            'Marvels of modern science',
            'Black History Months'
        ];

        foreach($books as $book) {
            $slug = SlugService::createSlug(Book::class, 'slug', $book);
            Book::factory()->create([
                'name' => $book,
                'slug' => $slug,
                'author_id' => rand(1, 6),
                'cover' => $slug.'.jpg',
                'pdf_file' => $slug.'.pdf',
            ]);
        }
    }
}
