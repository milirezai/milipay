<?php

namespace MiliPay;

use Illuminate\Support\ServiceProvider;


class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->publishes([
            gateConfig()->setFileConfigPath()->getFileConfigPath() => config_path('pay.php')
        ],'payHub-config');
        //  php artisan vendor:publish --tag=payHub-config
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

}
