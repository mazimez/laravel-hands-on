<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $location = fake()->randomElement(config('default_locations'));
        return [
            'type' => User::USER,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->numerify('##########'),
            'password' => bcrypt('password'),
            'profile_image' => fake()->randomElement(config('default_images')),
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function verified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => Carbon::now(),
        ]);
    }
}