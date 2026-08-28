<?php

namespace Mili\Milipay;

use Mili\Milipay\Contracts\ResponseHandler;
use Mili\Milipay\Contracts\PayloadBuilder;
use Mili\Milipay\Drivers\Zarinpal\Zarinpal;
use Mili\Milipay\Drivers\Zibal\Zibal;
use Mili\Milipay\Facades\MilipayRegistry;
use Mili\Milipay\PayloadBuilders\ZarinpalPayloadBuilder;
use Mili\Milipay\PayloadBuilders\ZibalPayloadBuilder;
use Mili\Milipay\Registry\PayRegistry;
use Mili\Milipay\Response\Adapters\Zarinpal as ZarinpallAdapter;
use Mili\Milipay\Response\Adapters\Zibal as ZibalAdapter;
use Illuminate\Support\ServiceProvider;

class MilipayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->publishes([
            __DIR__.'/../pay.php' => config_path('pay.php')
        ],'milipay-config');

        $this->app->when(Zarinpal::class)
            ->needs(PayloadBuilder::class)
            ->give(ZarinpalPayloadBuilder::class);

        $this->app->when(Zarinpal::class)
            ->needs(ResponseHandler::class)
            ->give(ZarinpallAdapter::class);

        $this->app->when(Zibal::class)
            ->needs(PayloadBuilder::class)
            ->give(ZibalPayloadBuilder::class);

        $this->app->when(Zibal::class)
            ->needs(ResponseHandler::class)
            ->give(ZibalAdapter::class);


        $this->app->bind('milipay',function (){
            return $this->app->make(Milipay::class);
        });

        $this->app->bind('MilipayRegistry',function (){
            return $this->app->make(PayRegistry::class);
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        MilipayRegistry::drivers([
            \Mili\Milipay\Drivers\Zibal\Zibal::class,
            \Mili\Milipay\Drivers\Zarinpal\Zarinpal::class
        ])->pipes([
            \Mili\Milipay\Validation\Validation::class,
            \Mili\Milipay\Invoice\Resolve\ResolveData::class,
            \Mili\Milipay\Invoice\Dto\Dto::class,
            \Mili\Milipay\Core\PayEngine::class
        ])->facades([
            \Mili\Milipay\Facades\MilipayRegistry::class,
            \Mili\Milipay\Facades\Milipay::class,
        ])->adapters([
            \Mili\Milipay\Response\Adapters\Zarinpal::class,
            \Mili\Milipay\Response\Adapters\Zibal::class,
        ])->payloadBuilders([
            \Mili\Milipay\PayloadBuilders\ZibalPayloadBuilder::class,
            \Mili\Milipay\PayloadBuilders\ZarinpalPayloadBuilder::class,
        ]);
    }
}
