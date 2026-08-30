<?php

namespace Mili\Milipay\Facades;

use Illuminate\Support\Facades\Facade;

class Milipay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'milipay';
    }

}

