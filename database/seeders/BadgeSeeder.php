<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_post_badge = Badge::updateOrCreate([
            'slug' => Badge::FIRST_POST,
        ], [
            'name' => "First Spark",
            'description' => "Given when user post something for the first time.",
        ]);
    }
}
