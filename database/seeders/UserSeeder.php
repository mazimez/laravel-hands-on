<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::withoutEvents(function () {
            $default_user = User::create([
                'type' => User::USER,
                'name' => 'Default User',
                'email' => 'test@gmail.com',
                'password' => bcrypt('password'),
            ]);
            $laravel_tag = Tag::where('name', 'PHP')->first();
            if ($laravel_tag) {
                UserTag::create([
                    'user_id' => $default_user->id,
                    'tag_id' => $laravel_tag->id,
                ]);
            }
            $node_tag = Tag::where('name', 'node')->first();
            if ($node_tag) {
                UserTag::create([
                    'user_id' => $default_user->id,
                    'tag_id' => $node_tag->id,
                ]);
            }

            User::create([
                'type' => User::ADMIN,
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ]);
        });

        // $unverified_users = User::factory(10)->unverified()->create();
        $verified_users = User::factory(20)->verified()->createQuietly();

        foreach ($verified_users as $user) {
            $files = File::factory(3)->for($user, 'owner')->make();
            $user->files()->saveMany($files);

            $user_ids = User::inRandomOrder()->where('id', '!=', $user->id)->limit(rand(0, 5))->get()->pluck('id');
            $user->followers()->sync($user_ids);
        }
    }
}
