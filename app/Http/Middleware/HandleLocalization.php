<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-App-Locale')) {
            //checking if header has provided the supported language keys then updating the locale of app
            if (in_array($request->header('X-App-Locale'), ['sv', 'en'])) {
                $local = $request->header('X-App-Locale');
                app()->setLocale($local);
            }
        }

        return $next($request);
    }
}
