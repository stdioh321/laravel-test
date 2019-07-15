<?php

namespace App\Http\Middleware;

// use Illuminate\Http\RedirectResponse;

use Closure;
use Illuminate\Support\Facades\App;

class CheckAge
{
    protected $languages = ['en', 'fr','pt'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('lang')) {
            error_log($request->getPreferredLanguage($this->languages));
            // print_r($this);
            App::setLocale($request->input('lang'));
        }
        return $next($request);
    }
}
