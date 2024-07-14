<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

trait Base64Manager
{
    /**
     * Generates a unique random filename for a file to be stored on a specific disk.
     *
     * This function generates a random string of 20 characters using Laravel's 
     * `Str::random` method and appends the provided file extension. It then checks 
     * if a file with that name and extension already exists on the storage disk 
     * (defaults to "public"). If it exists, it regenerates a new random filename 
     * until a unique one is found. This helps prevent file name conflicts during 
     * storage operations.
     *
     * @param string $extension The required file extension to be appended to the 
     *                           generated filename.
     * @return string A unique random filename with the provided extension.
     */
    protected function generateFileName($extension)
    {
        $filename = Str::random(20);

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::exists($filename . '.' . $extension)) {
            $filename = Str::random(20);
        }

        return $filename;
    }

    /**
     * Stores a base64 encoded string as a file on the public disk.
     *
     * This function takes a base64 encoded string representation of an image, a path
     * within the public disk to store the file, and an optional extension (defaults
     * to "png"). It decodes the base64 data, generates a unique filename with the
     * provided extension, stores the decoded content on the public disk using the
     * generated path, and returns the final file path.
     *
     * @param string $base64 The base64 encoded string of the image data.
     * @param string $path The path within the public disk to store the file (relative to the "public" directory).
     * @param string $extension The optional file extension (defaults to "png").
     * @return string The full path of the stored file (including filename and extension).
     * @throws InvalidArgumentException If the provided base64 data is invalid.
     */
    public function base64ToFile($base64, $path, $extension = "png")
    {
        // Decode the base64 string
        if (!$content = base64_decode($base64)) {
            throw new InvalidArgumentException('Invalid base64 encoded data');
        }

        $fileName = $this->generateFileName($extension) . '.' . $extension;

        // Define the file path
        $filePath = $path . '/' . $fileName;

        // Store the file to the public disk
        Storage::put($filePath, $content);

        // Return the file path
        return $filePath;
    }

    /**
     * Converts a file stored on Laravel's storage disk to a base64 encoded string.
     *
     * This function takes the path to a file stored on one of Laravel's storage disks
     * (defaults to "public") and returns the base64 encoded representation of the 
     * file's content. It first checks if the file exists using the `Storage::exists` 
     * method. If the file doesn't exist, an `InvalidArgumentException` is thrown. 
     * Otherwise, it retrieves the full file path using `Storage::path` and reads the 
     * content using `file_get_contents`. Finally, it encodes the content into a base64 
     * string and returns it.
     *
     * @param string $path The path to the file within the storage disk (relative to 
     *                       the disk's root).
     * @return string The base64 encoded representation of the file's content.
     * @throws InvalidArgumentException If the file does not exist on the storage disk.
     */
    public function fileToBase64($path)
    {
        if (!Storage::exists($path)) {
            throw new InvalidArgumentException("File '$path' does not exist.");
        }

        $content = file_get_contents(Storage::path($path));
        return base64_encode($content);
    }
}
