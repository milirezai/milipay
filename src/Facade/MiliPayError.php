<?php

namespace MiliPay\Facade;

use Illuminate\Support\Facades\Facade;

class MiliPayError extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'milipay-error-handler-facade';
    }
}

