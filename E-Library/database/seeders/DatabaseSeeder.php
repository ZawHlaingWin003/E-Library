<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdminUser;
use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(5)->create();
        User::create([
            'name' => 'Kylo',
            'phone' => '09788185771',
            'email' => 'kylo@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        Genre::create([
            'name' => 'Horror'
        ]);
        Genre::create([
            'name' => 'Romance Novel'
        ]);
        Genre::create([
            'name' => 'Humor'
        ]);

        $this->call([AdminUserSeeder::class]);

    }
}
