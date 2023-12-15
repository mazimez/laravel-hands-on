<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //going throw all the default images from config
        foreach (config('default_images') as $image_name) {
            //getting the URL of an Image
            $url = url('/').'/'.$image_name;
            try {
                //getting the content of image to store in Storage
                $file = file_get_contents($url);
            } catch (Throwable $th) {
                return null;
            }

            //storing the image with same name as in Config.
            if (! Storage::exists("{$image_name}")) {
                Storage::put("{$image_name}", $file);
            }
        }

        //going throw all the default images from config
        foreach (config('default_videos') as $video_name) {
            //getting the URL of an Image
            $url = url('/').'/'.$video_name;
            try {
                //getting the content of image to store in Storage
                $file = file_get_contents($url);
            } catch (Throwable $th) {
                return null;
            }

            //storing the image with same name as in Config.
            if (! Storage::exists("{$video_name}")) {
                Storage::put("{$video_name}", $file);
            }
        }
    }
}
