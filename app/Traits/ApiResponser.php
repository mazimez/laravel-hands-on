<?php

namespace App\Traits;

trait ApiResponser
{
    //this method is used whenever we want to show some kind of error
    protected function errorResponse($message)
    {
        return response()->json([
            'message' => $message,
            'status' => '0',
        ]);
    }
}
