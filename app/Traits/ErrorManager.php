<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ErrorManager
{
    /**
     * Register the error
     *
     * @param  string  $message - message explaining errors
     * @param  string  $invoking_file_path - file path from where this method is called
     * @param  string  $error_line_number - number of line where the error happens
     * @param  string  $file_path - file path from where the actual error happens
     */
    public static function registerError($message, $invoking_file_path, $error_line_number, $file_path)
    {
        $log_message = PHP_EOL;
        $log_message = $log_message.'-------------------------------------------------------'.PHP_EOL;
        $log_message = $log_message.'Error Message: '.$message.PHP_EOL;
        $log_message = $log_message.'Error Invoking File Path: '.$invoking_file_path.PHP_EOL;
        $log_message = $log_message.'Error File Path: '.$file_path.PHP_EOL;
        $log_message = $log_message.'Error Line Number: '.$error_line_number.PHP_EOL;
        $log_message = $log_message.'-------------------------------------------------------'.PHP_EOL;
        Log::channel('errors')->error($log_message);
    }
}
