<?php

namespace Milipay\Drivers;


use Milipay\Facades\MilipayRegistry;

class Driver
{

    public function via(string $name): mixed
    {

       return collect(MilipayRegistry::getDrivers())->map(function ($driver) use ($name){
            $instance = app()->make($driver);
            if ($instance->name == $name)
                return $instance;
        })->filter(function ($driver){
            return $driver != null;
       })->whenEmpty(function () {
           exit('driver not found');
       })->first();

    }
}
