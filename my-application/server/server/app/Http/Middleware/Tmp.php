<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Tmp extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        
        if (!$request->expectsJson()) {
            // return route('login');
        }
    }
    public function handle($request, Closure $next, $guard = null)
    {
        error_log($guard.' TMPPPP');
        return $next($request);
    }
}
