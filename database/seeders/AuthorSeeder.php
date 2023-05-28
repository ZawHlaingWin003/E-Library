<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            'William Shakespeare',
            'Jane Austen',
            'Danielle Steel',
            'Sidney Sheldon',
            'Enid Blyton',
            'Nora Roberts'
        ];

        foreach($authors as $author) {
            Author::factory()->create([
                'name' => $author,
                'profile' => strtolower(str_replace(' ', '-', $author)).'.png',
            ]);
        }
    }
}
