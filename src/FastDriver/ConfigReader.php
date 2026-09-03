<?php

namespace Mili\Milipay\FastDriver;

class ConfigReader
{
    public function read(): array
    {
        return pay_config('fastDriver');
    }
    public function enabled(): bool
    {
        return (bool) ($this->read()['enabled'] ?? false);
    }
    public function every(): int
    {
        return (int) ($this->read()['every'] ?? 15);
    }
    public function sandbox(): array
    {
        return $this->read()['sandbox'];
    }
    public function storages(): array
    {
        return $this->read()['storages'];
    }
    public function sandboxDrivers(): array
    {
        return array_keys($this->sandbox()['drivers']);
    }
    public function numberOfProbePerDriver(): int
    {
        return $this->read()['numberOfProbePerDriver'];
    }
}
