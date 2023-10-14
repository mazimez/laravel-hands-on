<?php

namespace App\Traits;

use Exception;
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
     * @return string the storage path of new file
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
     * Upload file from URL into system
     *
     * @param $url - the URL of file(it could be image, PDF, DOC etc.)
     * @param string $folder_path - the path of folders where this file should be uploaded
     * @return string the storage path of new file
     */
    protected function saveFileFromUrl($url, string $model_name)
    {
        try {
            $file  = file_get_contents($url);
        } catch (Throwable $th) {
            return null;
        }

        $info = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = $info->buffer($file);
        $extension = null;
        if (empty($mime_type)) {
            throw new Exception(__('messages.extension_not_found'));
        } else {
            $extension = substr($mime_type, strpos($mime_type, '/') + 1);
        }

        $filename = Str::random(30);
        while (Storage::exists("{$model_name}/{$filename}.{$extension}")) {
            $filename = Str::random(30);
        }

        if (Storage::put("{$model_name}/{$filename}.{$extension}", $file)) {
            return "{$model_name}/{$filename}.{$extension}";
        } else {
            null;
        }
    }


    /**
     * Delete any file from system
     *
     * @param string $path - path where the file is stored
     */
    public function deleteFile($path)
    {
        try {
            //TODO::this doesn't work properly while running testing, the config method somehow doesn't work. fix it
            if (Storage::exists($path)) {
                if (!in_array($path, config('default_images'))) {
                    if (!in_array($path, config('default_videos'))) {
                        Storage::delete($path);
                    }
                }
            }
        } catch (\Throwable $th) {
        }
    }
}
