<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'name' => $name,
            'biography' => $this->faker->paragraph(20),
            // 'profile' => $this->faker->image('storage/app/public/authors', 300, 300, 'author')
        ];
    }
}
