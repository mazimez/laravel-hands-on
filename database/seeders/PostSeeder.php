<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostFile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory(50)->create();
        foreach ($posts as $post) {
            PostFile::factory(2)->for($post)->create();
            PostComment::factory(15)->for($post)->create();
            $user_ids = User::inRandomOrder()->limit(4)->get()->pluck('id');
            $post->likers()->sync($user_ids);
        }
    }
}
