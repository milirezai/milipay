<?php

namespace MiliPay\Support\Trait;

use MiliPay\Config\ConfigGateway;
use MiliPay\ErrorHandler\PaymentErrorHandler;

trait Serviceable
{
    public function isEnable():bool
    {
        if (gateConfig()->driver($this->driver)->status())
            return true;
        else
            errorHandler()
                ->set('The driver is not serviceable.')
                ->log()
                ->error()
                ->toException();
    }
}
