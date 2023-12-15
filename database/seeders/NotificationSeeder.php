<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Post;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Notification::factory(10)->createQuietly([
            'click_action' => Notification::DO_NOTHING,
        ]);
        $posts = Notification::factory(10)->for(Post::inRandomOrder()->first())->createQuietly([
            'click_action' => Notification::OPEN_POST,
            'type' => Notification::POST_LIKED,
            'meta_data' => ['post_id' => 'some id of post'],
        ]);
    }
}
