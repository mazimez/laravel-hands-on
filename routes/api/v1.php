<?php

use Illuminate\Support\Facades\Route;
use App\Traits\SaveFile;
use Illuminate\Foundation\Http\FormRequest;

Route::group(['middleware' => ['localization']], function () {
    Route::get('test', function () {
        return __('messages.test');
    });


    Route::post('upload-file', 'v1\TestController@fileUpload');
    Route::post('delete-file', 'v1\TestController@fileDestroy');

    Route::post('users/login', 'v1\UserController@login');
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //USER
        Route::group(['prefix' => 'users'], function () {
            Route::get('/detail', 'v1\UserController@show');
        });
    });
});
