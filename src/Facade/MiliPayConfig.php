<?php

namespace MiliPay\Facade;

use Illuminate\Support\Facades\Facade;

class MiliPayConfig extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'milipay-config-gateway-facade';
    }
}

