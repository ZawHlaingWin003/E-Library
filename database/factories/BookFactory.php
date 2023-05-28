<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $likes = rand(5, 20);
        $views = rand(10, 30);
        $views = $views > $likes ? rand(10, 30) : $views;

        return [
            'excerpt' => $this->faker->paragraph(6),
            'published_at' => $this->faker->date(),
            'likes' => $likes,
            'views' => $views,
        ];
    }
}
