<?php

namespace Mili\Milipay;

use Illuminate\Support\ServiceProvider;
use Mili\Milipay\Contracts\PayloadBuilder as PayloadBuilderContract;
use Mili\Milipay\Contracts\ResponseHandler as ResponseHandlerContract;
use Mili\Milipay\Drivers\Zarinpal\Response as ZarinpalAdapter;
use Mili\Milipay\Drivers\Zarinpal\Zarinpal;
use Mili\Milipay\Drivers\Zarinpal\PayloadBuilder as ZarinpalPayloadBuilder;
use Mili\Milipay\Drivers\Zibal\Response as ZibalAdapter;
use Mili\Milipay\Drivers\Zibal\Zibal;
use Mili\Milipay\Drivers\Zibal\PayloadBuilder as ZibalPayloadBuilder;
use Mili\Milipay\Facades\Registry as FacadeRegistry;
use Mili\Milipay\Registry\Registry;

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
            ->needs(PayloadBuilderContract::class)
            ->give(ZarinpalPayloadBuilder::class);

        $this->app->when(Zarinpal::class)
            ->needs(ResponseHandlerContract::class)
            ->give(ZarinpalAdapter::class);

        $this->app->when(Zibal::class)
            ->needs(PayloadBuilderContract::class)
            ->give(ZibalPayloadBuilder::class);

        $this->app->when(Zibal::class)
            ->needs(ResponseHandlerContract::class)
            ->give(ZibalAdapter::class);


        $this->app->bind('milipay',function (){
            return $this->app->make(Milipay::class);
        });

        $this->app->bind('Registry',function (){
            return $this->app->make(Registry::class);
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FacadeRegistry::drivers([
            \Mili\Milipay\Drivers\Zibal\Zibal::class,
            \Mili\Milipay\Drivers\Zarinpal\Zarinpal::class
        ])->pipes([
            \Mili\Milipay\Validation\Validation::class,
            \Mili\Milipay\Invoice\ResolveData::class,
            \Mili\Milipay\Invoice\Dto::class,
            \Mili\Milipay\Core\Engine::class
        ])->facades([
            \Mili\Milipay\Facades\Registry::class,
            \Mili\Milipay\Facades\Milipay::class,
        ])->adapters([
            \Mili\Milipay\Drivers\Zarinpal\Response::class,
            \Mili\Milipay\Drivers\Zibal\Response::class,
        ])->payloadBuilders([
            \Mili\Milipay\Drivers\Zibal\PayloadBuilder::class,
            \Mili\Milipay\Drivers\Zarinpal\PayloadBuilder::class,
        ]);
    }
}
