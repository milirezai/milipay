<?php

namespace Milipay\Core;

use Milipay\Contracts\DriverContract;
use Milipay\Contracts\PipelinePayContract;
use Milipay\Drivers\Driver;
use Milipay\Invoice\Dto\Dto;
use Milipay\Response\PayResult;
use Closure;

class PayEngine implements PipelinePayContract
{
    private  Driver $driver;
    private Dto $data;

    private DriverContract $gatewayInstance;

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
