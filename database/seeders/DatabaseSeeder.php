<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AdminUserSeeder::class,
            GenreSeeder::class,
            AuthorSeeder::class,
            BookSeeder::class,
            BookGenreSeeder::class
        ]);
    }
}