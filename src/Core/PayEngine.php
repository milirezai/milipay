<?php

namespace Mili\Milipay\Core;

use Mili\Milipay\Contracts\Driver;
use Mili\Milipay\Contracts\PipelinePay;
use Mili\Milipay\Drivers\Driver as DriverInstance;
use Mili\Milipay\Invoice\Dto\Dto;
use Mili\Milipay\Response\PayResult;
use Closure;

class PayEngine implements PipelinePay
{
    private  Driver $driver;
    private Dto $data;

    private DriverInstance $gatewayInstance;

    public function __construct(Driver $driver,protected readonly PayResult $response)
    {
        $this->driver = $driver;
    }

    public function handle($data, Closure $next)
    {
        $this->data = $data;
        return $this->process();
    }

    private function process(): mixed
    {
        // get driver name
        $driverName = $this->data->driver();

        // select driver instance
        $this->gatewayInstance = $this->driver->via(name: $driverName);

        // operation
        $operation = $this->data->operation();

        return $this->resolveOperationMethod($operation);
    }
    private function resolveOperationMethod(string $name)
    {
        switch ($name){
            case 'request':
                return $this->gatewayInstance->request($this->data);
            case 'verify':
                return $this->gatewayInstance->verify($this->data);
            case 'inquiry':
                return $this->gatewayInstance->inquiry($this->data);
        }
    }

}
