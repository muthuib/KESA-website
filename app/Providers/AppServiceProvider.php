<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MpesaPayment;
use App\Observers\MpesaPaymentObserver;

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
        MpesaPayment::observe(MpesaPaymentObserver::class);
    }
}
