<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyUserAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()) {
            return response()->json([
                'message' => __('messages.unauthenticated'),
                'status' => '401',
            ], 401);
        }
        if (Auth::user()->type != User::USER) {
            return response()->json([
                'message' => __('messages.only_user_allowed'),
                'status' => '0',
            ]);
        }
        return $next($request);
    }
}