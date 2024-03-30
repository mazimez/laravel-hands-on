<?php

use Illuminate\Support\Facades\Route;

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

        //USER FOLLOW
        Route::get('/{user}/followers', 'v1\UserFollowController@followers');
        Route::get('/{user}/following', 'v1\UserFollowController@following');
        Route::post('/{user}/follow-toggle', 'v1\UserFollowController@toggle');
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
            Route::post('/{comment}/edit', 'v1\PostCommentController@update');
            Route::delete('/{comment}/delete', 'v1\PostCommentController@destroy');
        });

        //POST-FILES
        Route::group(['prefix' => '{post}/files'], function () {
            Route::delete('/{file}/delete', 'v1\PostFileController@destroy');
        });

        //POST-LIKE
        Route::group(['prefix' => '{post}/likes'], function () {
            Route::get('/', 'v1\PostLikeController@index');
            Route::post('/toggle', 'v1\PostLikeController@toggle');
        });
    });
});
