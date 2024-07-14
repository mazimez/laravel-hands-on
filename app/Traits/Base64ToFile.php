<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

trait Base64ToFile
{
    /**
     * Generates a unique random filename for a file to be stored on a specific disk.
     *
     * This function uses Laravel's `Str::random` method to generate a random string
     * of 20 characters. It then checks if a file with that name and the `.pdf` extension
     * already exists on the specified storage disk. If it exists, it regenerates a new
     * random filename until a unique one is found.
     *
     * @param string $disk The name of the disk to use for uniqueness checks.
     * @return string A unique random filename without the extension.
     *
     * @throws RuntimeException If a unique filename cannot be generated after a
     *   reasonable number of attempts.
     */
    protected function generateFileName()
    {
        $filename = Str::random(20);

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::exists($filename . '.pdf')) {
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

        $fileName = $this->generateFileName() . '.' . $extension;

        // Define the file path
        $filePath = $path . '/' . $fileName;

        // Store the file to the public disk
        Storage::put($filePath, $content);

        // Return the file path
        return $filePath;
    }
}
