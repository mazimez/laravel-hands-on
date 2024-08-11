<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Post;
use App\Models\PostComment;
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
        $posts = Post::factory(30)->create();
        foreach ($posts as $post) {
            $files = File::factory(3)->for($post->user, 'owner')->make();
            $post->files()->saveMany($files);
            $comments = PostComment::factory(15)->for($post)->create();
            $user_ids = User::inRandomOrder()->limit(rand(0, 5))->get()->pluck('id');
            $post->likers()->sync($user_ids);
            foreach ($comments as $comment) {
                $comment->likers()->sync($user_ids);
            }
        }
    }
}
