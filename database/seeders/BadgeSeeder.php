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
        $email_verified_badge = Badge::updateOrCreate([
            'slug' => Badge::EMAIL_VERIFIED,
        ], [
            'name' => "Email Verifier",
            'description' => "Given when user Verify it's email",
        ]);
        $phone_verified_badge = Badge::updateOrCreate([
            'slug' => Badge::PHONE_VERIFIED,
        ], [
            'name' => "Phone Verifier",
            'description' => "Given when user Verify it's phone number",
        ]);
    }
}