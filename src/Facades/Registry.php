<?php

namespace Mili\Milipay\Facades;

use Illuminate\Support\Facades\Facade;

class Registry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Registry';
    }

}

