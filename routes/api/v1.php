<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::get('test', function () {
        return __('messages.test');
    });

    Route::post('users/login', 'v1\UserController@login');
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //USER
        Route::group(['prefix' => 'users'], function () {
            Route::get('/detail', 'v1\UserController@show');
        });
    });
});
