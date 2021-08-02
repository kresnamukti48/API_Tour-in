<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;
use Schema;
use Xendit\Xendit;

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
        Schema::defaultStringLength(191);

        // Payment gateway config

        // Midtrans
        Config::$serverKey = config('tourin.payment.midtrans.server_key');
        Config::$isProduction = config('tourin.payment.midtrans.production');
        Config::$isSanitized = config('tourin.payment.midtrans.sanitized');
        Config::$is3ds = config('tourin.payment.midtrans.3ds');

        // Xendit
        Xendit::setApiKey(config('tourin.payment.xendit.secretKey'));

        // End of payment gateway config
    }
}
