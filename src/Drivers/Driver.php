<?php

namespace Mili\Milipay\Drivers;

use Mili\Milipay\Exceptions\MilipayException;
use Mili\Milipay\Facades\Registry;

class Driver
{
    public function via(string $name): mixed
    {
       return collect(Registry::getDrivers())->map(function ($driver) use ($name){
            $instance = app()->make($driver);
            if ($instance->name == $name)
                return $instance;
        })->filter(function ($driver){
            return $driver != null;
       })->whenEmpty(function () {
           throw new MilipayException('driver not found');
       })->first();
    }
}
