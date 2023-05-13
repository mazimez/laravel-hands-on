<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::get('test', function () {
        return __('messages.test');
    });
});
