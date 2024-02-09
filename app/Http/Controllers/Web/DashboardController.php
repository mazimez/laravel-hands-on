<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $user_count = User::where('type', User::USER)->count();
        $active_post_count = Post::count();
        $unverified_post_count = Post::withoutGlobalScope('active')->where('is_blocked', 0)->where('is_verified', 0)->count();
        $blocked_post_count = Post::withoutGlobalScope('active')->where('is_blocked', 1)->count();

        return view('UI.home', [
            'page_title' => 'Dashboard',
            'user_count' => $user_count,
            'active_post_count' => $active_post_count,
            'unverified_post_count' => $unverified_post_count,
            'blocked_post_count' => $blocked_post_count,
        ]);
    }
}
