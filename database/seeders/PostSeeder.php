<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostFile;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::factory(30)->create();
        foreach ($posts as $post) {
            PostFile::factory(2)->for($post)->create();
            $comments = PostComment::factory(15)->for($post)->create();
            $user_ids = User::inRandomOrder()->limit(rand(0, 5))->get()->pluck('id');
            $post->likers()->sync($user_ids);
            foreach ($comments as $comment) {
                $comment->likers()->sync($user_ids);
            }
        }
    }
}
