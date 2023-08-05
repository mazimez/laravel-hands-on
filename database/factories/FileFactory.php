<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $is_photo = fake()->randomElement([1, 0]);
        if ($is_photo) {
            return [
                'file_path' => fake()->randomElement(config('default_images')),
                'type' => File::PHOTO,
            ];
        } else {
            return [
                'file_path' => fake()->randomElement(config('default_videos')),
                'type' => File::VIDEO,
            ];
        }
    }
}
