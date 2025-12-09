<?php

namespace MiliPay\Facade;

use Illuminate\Support\Facades\Facade;

class MiliPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'milipay-facade';
    }
}

