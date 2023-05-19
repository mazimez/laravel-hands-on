<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait FileManager
{

    /**
     * Upload file into system
     *
     * @param $file - the file that needs to be uploaded
     * @param string $folder_path - the path of folders where this file should be uploaded
     * @return string
     */
    protected function saveFile($file, string $folder_path)
    {
        //generating a unique random name for file
        $filename = Str::random(30);
        $extension = $file->getClientOriginalExtension();
        while (Storage::exists("{$folder_path}/{$filename}.{$extension}")) {
            $filename = Str::random(30);
        }


        //saving file into given path
        Storage::put("{$folder_path}/{$filename}.{$extension}", file_get_contents($file->getRealPath()));


        $path = "{$folder_path}/{$filename}.{$extension}";
        return $path;
    }

    /**
     * Delete any file from system
     *
     * @param string $path - path where the file is stored
     */
    public function deleteFile($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}