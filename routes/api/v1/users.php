<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    //NO-AUTH
    Route::post('users/login', 'v1\UserController@login');
    Route::post('users/social-login', 'v1\UserController@socialLogin');
    Route::post('users/register', 'v1\UserController@store');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        //USER
        Route::group(['prefix' => 'users'], function () {
            Route::group(['middleware' => ['only_admin_allowed']], function () {
                Route::get('/', 'v1\UserController@index');
                Route::get('/export', 'v1\UserController@excelExport');
            });
            Route::get('/detail', 'v1\UserController@show');
            Route::post('/update', 'v1\UserController@update');
            Route::post('/logout', 'v1\UserController@logout');
            Route::group(['middleware' => ['only_user_allowed']], function () {
                Route::post('/verify-phone', 'v1\UserController@verifyPhone');
                Route::post('/confirm-phone', 'v1\UserController@confirmPhone');
            });

            //USER FILES
            Route::group(['prefix' => '{user}/files'], function () {
                Route::get('/', 'v1\UserFileController@index');
                Route::delete('/{file}/delete', 'v1\UserFileController@destroy');
                Route::group(['middleware' => ['only_user_allowed']], function () {
                    Route::post('/add', 'v1\UserFileController@store');
                });
            });

            //USER FOLLOW
            Route::get('/{user}/followers', 'v1\UserFollowController@followers');
            Route::get('/{user}/following', 'v1\UserFollowController@following');
            Route::group(['middleware' => ['only_user_allowed']], function () {
                Route::post('/{user}/follow-toggle', 'v1\UserFollowController@toggle');
            });

            //USER BADGES
            Route::group(['prefix' => '{user}/badges'], function () {
                Route::get('/', 'v1\UserBadgeController@index');
            });
        });
    });
});
