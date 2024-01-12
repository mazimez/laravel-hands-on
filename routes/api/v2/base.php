<?php

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    $user = User::where('id', 1)->first();
    $cache_key = 'user_'.$user->id.'_tag_ids';
    // Cache::put($cache_key, $user->tags->pluck('id')->toArray(), now()->addWeek());
    return Cache::get($cache_key);
});
