<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TransaksiKas;
use App\TransaksiKartuKredit;
use App\Observers\TransaksiKasObserver;
use App\Observers\TransaksiKartuKreditObserver;
use App\JurnalManual;
use App\Observers\JurnalManualObserver;
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
        TransaksiKartuKredit::observe(TransaksiKartuKreditObserver::class);
        JurnalManual::observe(JurnalManualObserver::class);
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
