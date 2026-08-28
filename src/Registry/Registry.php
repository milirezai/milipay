<?php

namespace Mili\Milipay\Registry;

use Mili\Milipay\Contracts\PayRegistry as RegistryContract;

class Registry implements RegistryContract
{
    protected array $drivers;
    protected array $adapters;
    protected array $facades;
    protected array $commands;
    protected array $pipes;
    protected array $payloadBuilders;

    public function drivers(array $drivers): self
    {
        $this->drivers = $drivers;
        return $this;
    }

    public function getDrivers(): array
    {
        return $this->drivers;
    }

    public function adapters(array $adapters): self
    {
        $this->adapters = $adapters;
        return $this;
    }

    public function getAdapters(): array
    {
        return $this->adapters;
    }

    public function facades(array $facades): self
    {
        $this->facades = $facades;
        return $this;
    }

    public function getFacades(): array
    {
        return $this->facades;
    }

    public function commands(array $commands): self
    {
        $this->commands = $commands;
        return $this;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function pipes(array $pipes): self
    {
        $this->pipes = $pipes;
        return $this;
    }

    public function getPipes(): array
    {
        return $this->pipes;
    }
    public function payloadBuilders(array $payloadBuilder): self
    {
        $this->payloadBuilders = $payloadBuilder;
        return $this;
    }
    public function getPayloadBuilders(): array
    {
        return $this->payloadBuilders;
    }
}
