<?php

namespace Database\Seeders;

use App\Models\BookGenre;
use Illuminate\Database\Seeder;

class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookGenre = [
            [
                'book_id' => 1,
                'genre_id' => [2, 4, 6]
            ],
            [
                'book_id' => 2,
                'genre_id' => [1, 4, 9]
            ],
            [
                'book_id' => 3,
                'genre_id' => [1, 2, 10]
            ],
            [
                'book_id' => 4,
                'genre_id' => [7, 8]
            ],
            [
                'book_id' => 5,
                'genre_id' => [3, 5, 6]
            ]
        ];

        foreach ($bookGenre as $item) {
            $bookId = $item['book_id'];
            $genreIds = $item['genre_id'];
        
            foreach ($genreIds as $genreId) {
                BookGenre::create([
                    'book_id' => $bookId,
                    'genre_id' => $genreId,
                ]);
            }
        }
    }
}
