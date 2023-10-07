<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement([
                fake()->jobTitle(),
                fake()->company(),
                fake()->colorName(),
                fake()->city(),
                fake()->country()
            ]),
            'color_hex' => fake()->unique()->hexColor()
        ];
    }
}
