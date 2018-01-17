<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TransaksiKas;
use App\Observers\TransaksiKasObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        TransaksiKas::observe(TransaksiKasObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
