<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['Horror', 'Mystery', 'Fiction', 'Thriller', 'Biography', 'Religion', 'Romance', 'Poetry', 'Literary Fiction', 'Western Fiction', 'Drama', 'Humor', 'Travel Literature'];

        foreach($genres as $genre){
            Genre::create([
                'name' => $genre
            ]);
        }
    }
}
