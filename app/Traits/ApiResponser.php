<?php

namespace App\Traits;

trait ApiResponser
{
    //this method is used whenever we want to show some kind of error
    static function errorResponse($message, $status_code = 200)
    {
        return response()->json([
            'message' => $message,
            'status' => '0',
        ], $status_code);
    }
}
