<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //POST
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'v1\PostController@index');
            Route::get('/{post}', 'v1\PostController@show');
            Route::group(['middleware' => ['only_user_allowed']], function () {
                Route::post('/store', 'v1\PostController@store');
                Route::post('{post}/update', 'v1\PostController@update');
            });
            Route::delete('{post}/delete', 'v1\PostController@destroy');
            Route::group(['middleware' => ['only_admin_allowed']], function () {
                Route::post('{post}/verify-toggle', 'v1\PostController@verifyToggle');
                Route::post('{post}/block-toggle', 'v1\PostController@blockToggle');
            });

            //POST-COMMENTS
            Route::group(['prefix' => '{post}/comments'], function () {
                Route::get('/', 'v1\PostCommentController@index');
                Route::group(['middleware' => ['only_user_allowed']], function () {
                    Route::post('/create', 'v1\PostCommentController@store');
                    Route::post('/{comment}/edit', 'v1\PostCommentController@update');
                });
                Route::delete('/{comment}/delete', 'v1\PostCommentController@destroy');

                //POST-COMMENT-LIKE
                Route::group(['prefix' => '{comment}/likes'], function () {
                    Route::get('/', 'v1\PostCommentController@likeIndex');
                    Route::group(['middleware' => ['only_user_allowed']], function () {
                        Route::post('/toggle', 'v1\PostCommentController@likeToggle');
                    });
                });
            });

            //POST-FILES
            Route::group(['prefix' => '{post}/files'], function () {
                Route::delete('/{file}/delete', 'v1\PostFileController@destroy');
            });

            //POST-LIKE
            Route::group(['prefix' => '{post}/likes'], function () {
                Route::get('/', 'v1\PostLikeController@index');
                Route::group(['middleware' => ['only_user_allowed']], function () {
                    Route::post('/toggle', 'v1\PostLikeController@toggle');
                });
            });
        });
    });
});
