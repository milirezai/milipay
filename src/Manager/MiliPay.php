<?php

namespace MiliPay\Manager;

use MiliPay\Support\Contract\Gateway;
use MiliPay\Support\Contract\GatewayManager;
use MiliPay\Support\Trait\Serviceable;

class MiliPay implements GatewayManager
{
    protected string $driver = '';
    protected \Closure $closure;

    use Serviceable;

    public function viaDefaultDriver(): Gateway
    {
        if (empty($this->driver))
            $this->setDefaultDriver();
        if ($this->isEnable())
            return app()->make($this->getGatewayClass());
    }

    public function when(\Closure $closure): self
    {
        $this->closure = $closure;
        return $this;
    }

    public function via(string $driver, string $driverDefault = ''): Gateway
    {
        $closure = call_user_func($this->closure);
        if ($closure){
            $this->driver = $driver;
        }
        else{
            if (empty($driverDefault))
                $this->setDefaultDriver();
            else
                $this->driver = $driverDefault;
        }
        return $this->viaDefaultDriver();
    }

    protected function setDefaultDriver():void
    {
        $this->driver = gateConfig()->defaultDriver();
    }

    protected function getGatewayClass()
    {
        return gateConfig()->driver($this->driver)->manager();
    }

}