<?php

namespace Mili\Milipay\Core;

use Closure;
use Mili\Milipay\Contracts\Driver as DriverContract;
use Mili\Milipay\Contracts\PayPipeline;
use Mili\Milipay\Drivers\Driver as DriverFactory;
use Mili\Milipay\Invoice\Dto;

class Engine implements PayPipeline
{
    private Dto $data;
    private DriverContract $driverInstance;

    public function __construct(
        protected readonly DriverFactory $driverFactory
    ){}

    public function handle($data, Closure $next)
    {
        $this->data = $data;
        return $this->process();
    }

    private function process(): DriverContract
    {
        $this->driverInstance = $this->driverFactory->via(name: $this->data->driver());

        return $this->resolveOperation($this->data->operation());
    }
    private function resolveOperation(string $operation): DriverContract
    {
        return match ($operation){
            "request" => $this->driverInstance->request($this->data),
            "verify" => $this->driverInstance->verify($this->data),
            "inquiry" => $this->driverInstance->inquiry($this->data)
        };
    }

}
