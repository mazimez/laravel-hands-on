<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //TAG
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'v1\TagController@index');
        });
    });
});
