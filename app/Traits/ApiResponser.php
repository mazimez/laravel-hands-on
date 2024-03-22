<?php

namespace App\Traits;

trait ApiResponser
{
    /**
     * Create a new error response in JSON format
     *
     * @param  string  $message
     * @param  int  $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    static function errorResponse($message, $status_code = 200)
    {
        return response()->json([
            'message' => $message,
            'status' => '0',
        ], $status_code);
    }
}
