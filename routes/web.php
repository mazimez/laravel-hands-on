<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify/{hash}', 'Api\v1\UserController@verifyEmail')->name('email.verify');


Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('callback/google', function () {
    $social_user = Socialite::driver('google')->user();
    dd($social_user);
});

//AUTH MANAGEMENT
Route::get('/login', function () {
    if (Auth::user()) {
        return redirect('/home');
    }
    return view('auth.login');
});
Route::post('/login', 'Web\UserController@login')->name('login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('auth.home', ['user' => Auth::user()]);
    });
    Route::post('logout', 'Web\UserController@logout')->name('logout');
});
