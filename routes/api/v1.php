<?php

use Illuminate\Support\Facades\Route;

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
            Route::get('/', 'v1\UserController@index');
            Route::get('/detail', 'v1\UserController@show');
        });

        //POST
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'v1\PostController@index');
            Route::get('/{post}', 'v1\PostController@show');
            Route::post('/store', 'v1\PostController@store');
            Route::post('{post}/update', 'v1\PostController@update');
            Route::delete('{post}/delete', 'v1\PostController@destroy');

            //POST-COMMENTS
            Route::group(['prefix' => '{post}/comments'], function () {
                Route::get('/', 'v1\PostCommentController@index');
                Route::post('/create', 'v1\PostCommentController@store');
            });
        });
    });
});