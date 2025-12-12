<?php

namespace MiliPay\Support\Contract;

interface GatewayManager
{
    public function viaDefaultDriver():Gateway;

    public function when(\Closure $closure):self;
    public function via(string $driver, string $driverDefault = ''):Gateway;
}
