<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdminAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()) {
            return response()->json([
                'message' => __('messages.unauthenticated'),
                'status' => '401',
            ], 401);
        }
        if (Auth::user()->type != User::ADMIN) {
            return response()->json([
                'message' => __('messages.only_admin_allowed'),
                'status' => '0',
            ]);
        }
        return $next($request);
    }
}
