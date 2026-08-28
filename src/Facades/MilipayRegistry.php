<?php

namespace Mili\Milipay\Facades;

use Illuminate\Support\Facades\Facade;

class MilipayRegistry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MilipayRegistry';
    }

}

