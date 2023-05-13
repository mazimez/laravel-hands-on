<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //default language is set to be en(English)
        $local = 'en';
        if ($request->hasHeader('X-App-Locale')) {
            //checking if header has provided the supported language keys, if not then language is set back to English
            if (in_array($request->header('X-App-Locale'), ['sv', 'en'])) {
                $local = $request->header('X-App-Locale');
            } else {
                $local = 'en';
            }
        }
        app()->setLocale($local);
        return $next($request);
    }
}
