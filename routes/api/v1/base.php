<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    //TEST
    Route::get('test', function () {
        return __('messages.test');
    });
    Route::post('upload-file', 'v1\TestController@fileUpload')->name('test');
    Route::post('upload-file-from-url', 'v1\TestController@fileUploadFromUrl')->name('test');
    Route::post('delete-file', 'v1\TestController@fileDestroy');
    Route::post('send-mail', 'v1\TestController@sendMail');
    Route::post('google-login', 'v1\TestController@googleLogin');
    Route::post('send-otp', 'v1\TestController@sendOtp');
    Route::post('send-notification', 'v1\TestController@sendFcmNotification');
    Route::get('generate-pdf', 'v1\TestController@generatePdf');
    Route::get('generate-excel', 'v1\TestController@generateExcel');
});
