<?php

namespace MiliPay;

use Illuminate\Support\ServiceProvider;
use MiliPay\Gateways\Zarinpal\ZarinpalManager;
use MiliPay\Gateways\Zibal\ZibalManager;
use MiliPay\Manager\MiliPay;
use MiliPay\Response\GatewayResponseHandler;
use MiliPay\ResponseAdapters\ZarinpalAdapter;
use MiliPay\ResponseAdapters\ZibalAdapter;
use MiliPay\Support\Contract\ResponseAdapterHandler;


class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->publishes([
            gateConfig()->setFileConfigPath()->getFileConfigPath() => config_path('pay.php')
        ],'milipay-config');


         $this->app->when(ZarinpalManager::class)
             ->needs(ResponseAdapterHandler::class)
             ->give(ZarinpalAdapter::class);

        $this->app->when(ZibalManager::class)
            ->needs(ResponseAdapterHandler::class)
            ->give(ZibalAdapter::class);

        $this->app->bind('milipay-facade',function (){
            return $this->app->make(MiliPay::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

}
