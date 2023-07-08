<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\en_US\Person;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'title' => fake()->text(100),
            'description' => fake()->text(500),
            'is_verified' => fake()->randomElement([1, 1, 0]),
            'is_blocked' => fake()->randomElement([1, 1, 1, 0]),
            'meta_data' => [
                'mentioned_people' => [fake()->name, fake()->name, fake()->name],
            ]
        ];
    }
}
