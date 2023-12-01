<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //TAG
        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', 'v1\NotificationController@index');
        });
    });
});
