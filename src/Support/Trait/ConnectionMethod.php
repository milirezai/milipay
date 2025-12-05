<?php

namespace MiliPay\Support\Trait;

use MiliPay\Config\ConfigGateway;
use MiliPay\ErrorHandler\PaymentErrorHandler;

trait ConnectionMethod
{
    protected function setDefaultDriver():void
    {
        $this->driver = gateConfig()->defaultDriver();
    }
    protected function getGatewayClass()
    {
        return gateConfig()->driver($this->driver)->manager();
    }

    public function with(string $driver):self
    {
        if ($driver != ''){
            if (gateConfig()->driver($driver)->has()){
                $this->driver = $driver;
                return $this;
            }
                errorHandler()
                    ->set('Driver is not supported.')
                    ->log()
                    ->error()
                    ->toException();
        }
        errorHandler()
            ->set('The drive argument must be null inequality.')
            ->log()
            ->warning();
        $this->setDefaultDriver();
        return $this;
    }
}
