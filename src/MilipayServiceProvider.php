<?php

namespace Milipay;

use Milipay\Contracts\ResponseHandlerContract;
use Milipay\Contracts\PayloadBuilderContract;
use Milipay\Drivers\Zarinpal\Zarinpal;
use Milipay\Drivers\Zibal\Zibal;
use Milipay\Facades\MilipayRegistry;
use Milipay\PayloadBuilders\ZarinpalPayloadBuilder;
use Milipay\PayloadBuilders\ZibalPayloadBuilder;
use Milipay\Registry\PayRegistry;
use Milipay\Response\Adapters\Zarinpal as ZarinpallAdapter;
use Milipay\Response\Adapters\Zibal as ZibalAdapter;
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
        ],'milipay');

        $this->app->when(Zarinpal::class)
            ->needs(PayloadBuilderContract::class)
            ->give(ZarinpalPayloadBuilder::class);

        $this->app->when(Zarinpal::class)
            ->needs(ResponseHandlerContract::class)
            ->give(ZarinpallAdapter::class);

        $this->app->when(Zibal::class)
            ->needs(PayloadBuilderContract::class)
            ->give(ZibalPayloadBuilder::class);

        $this->app->when(Zibal::class)
            ->needs(ResponseHandlerContract::class)
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
            \Milipay\Drivers\Zibal\Zibal::class,
            \Milipay\Drivers\Zarinpal\Zarinpal::class
        ])->pipes([
            \Milipay\Invoice\Resolve\ResolveData::class,
            \Milipay\Invoice\Dto\Dto::class,
            \Milipay\Core\PayEngine::class
        ])->facades([
            \Milipay\Facades\MilipayRegistry::class,
            \Milipay\Facades\Milipay::class,
        ])->adapters([
            \Milipay\Response\Adapters\Zarinpal::class,
            \Milipay\Response\Adapters\Zibal::class,
        ])->payloadBuilders([
            \Milipay\PayloadBuilders\ZibalPayloadBuilder::class,
            \Milipay\PayloadBuilders\ZarinpalPayloadBuilder::class,
        ]);

    }
}
