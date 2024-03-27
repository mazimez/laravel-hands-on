<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostFile>
 */
class PostFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_photo = fake()->randomElement([1, 0]);
        if ($is_photo) {
            return [
                'post_id' => Post::inRandomOrder()->first()->id,
                'file_path' => fake()->randomElement(config('default_images')),
                'type' => PostFile::PHOTO,
            ];
        } else {
            return [
                'post_id' => Post::inRandomOrder()->first()->id,
                'file_path' => fake()->randomElement(config('default_videos')),
                'type' => PostFile::VIDEO,
            ];
        }
    }
}
