<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Default User',
            'email' => 'test@gamil.com',
            'password' => bcrypt('password')
        ]);
        $unverified_users = User::factory(10)->unverified()->create();
        $verified_users = User::factory(10)->verified()->create();
    }
}
