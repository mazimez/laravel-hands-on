<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostFile;
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
        $posts = Post::factory(10)->create();
        foreach ($posts as $post) {
            PostFile::factory(2)->for($post)->create();
            PostComment::factory(15)->for($post)->create();
        }
    }
}
