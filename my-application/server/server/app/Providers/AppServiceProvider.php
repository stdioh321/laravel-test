<?php

namespace App\Providers;

// use Illuminate\Support\Cabon;

use DateTime;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // \Carbon\Carbon::setLocale(config('app.locale'));

        // Carbon::setToStringFormat(DateTime::ISO8601);
        // Carbon::setToStringFormat('d-M-Y H:i');
    }
}
