<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

trait RouteHandler
{
    /**
     * configure API versioning in routes
     *
     * @return \Closure
     */
    static function configureApiVersioning()
    {
        return function () {

            //for v1
            Route::prefix('api/v1')
                ->middleware('api')
                ->namespace("App\Http\Controllers\Api")
                ->group(base_path('routes/api/v1.php'));


            //for v2
            Route::prefix('api/v2')
                ->middleware('api')
                ->namespace("App\Http\Controllers\Api")
                ->group(base_path('routes/api/v2.php'));
        };
    }
}
