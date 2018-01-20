<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TransaksiKas;
use App\Observers\TransaksiKasObserver;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
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
