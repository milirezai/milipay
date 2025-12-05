<?php

namespace MiliPay\Manager;

use MiliPay\Support\Contract\Gateway;
use MiliPay\Support\Contract\GatewayManager;
use MiliPay\Support\Trait\ConnectionMethod;
use MiliPay\Support\Trait\Serviceable;

class Payment implements GatewayManager
{
    protected string $driver = '';

    use ConnectionMethod,Serviceable;

    public function gate(): Gateway
    {
        if ($this->driver === '')
            $this->setDefaultDriver();
        if ($this->isEnable())
            return app()->make($this->getGatewayClass());
    }
}
