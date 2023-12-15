<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            ['name' => 'Laravel', 'color_hex' => '#a69a55'],
            ['name' => 'PHP', 'color_hex' => '#affc81'],
            ['name' => 'laravel-hands-on', 'color_hex' => '#1d2029'],
            ['name' => 'NPM', 'color_hex' => '#ec67f3'],
            ['name' => 'composer', 'color_hex' => '#02d03c'],
            ['name' => 'node', 'color_hex' => '#4ab9ee'],
            ['name' => 'javascript', 'color_hex' => '#c4f4b3'],
            ['name' => 'typescript', 'color_hex' => '#183a6c'],
            ['name' => 'Unity Engine', 'color_hex' => '#ffef0e'],
            ['name' => 'C#', 'color_hex' => '#cea7bb'],
        ]);
        $tags = Tag::factory(100)->create();
    }
}
