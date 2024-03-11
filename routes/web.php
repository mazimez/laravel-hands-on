<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//DEFAULT
Route::get('/', function () {
    return view('welcome');
});

//AUTH MANAGEMENT
Route::get('/login', function () {
    if (Auth::user()) {
        return redirect('/dashboard');
    }

    return view('UI.auth.login');
});
Route::post('/login', 'Web\UserController@login')->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/livewire-test', 'Web\TestController@testLivewire')->name('livewire-test');

    Route::get('dashboard', 'Web\DashboardController@show')->name('dashboard');

    Route::post('logout', 'Web\UserController@logout')->name('logout');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', 'Web\UserController@index')->name('index');
        Route::get('/create', 'Web\UserController@create')->name('create');
        Route::get('/{user}/edit', 'Web\UserController@edit')->name('edit');
        Route::get('/api', 'Web\UserController@indexApi')->name('api');
    });
});

//EMAIL-VERIFICATION
Route::get('/email/verify/{hash}', 'Api\v1\UserController@verifyEmail')->name('email.verify');

//TEST-ROUTES
Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('callback/google', function () {
    $social_user = Socialite::driver('google')->user();
    dd($social_user);
});