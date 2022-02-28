<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<int, string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->text(500),
        ];
    }
}
