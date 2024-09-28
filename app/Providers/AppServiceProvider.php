<?php

namespace App\Providers;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Observers\FileObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('post', function ($value) {
            return Post::withoutGlobalScope('active')->where('id', $value)->firstOrFail();
        });

        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);
        File::observe(FileObserver::class);
    }
}
