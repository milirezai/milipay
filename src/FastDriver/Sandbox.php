<?php

namespace Mili\Milipay\FastDriver;

use Mili\Milipay\FastDriver\Config\ConfigReader;
use Mili\Milipay\Exceptions\MilipayException;

class Sandbox
{
    private string $driver = '';
    public function __construct(
        protected readonly ConfigReader $configReader
    ){}

    public function for(string $driver): self
    {
        if (in_array($driver,array_keys($this->configReader->sandbox()['drivers']))){
            $this->driver = $driver;
            return $this;
        }
        throw new MilipayException('driver not sandbox');
    }
    public function driver(): string
    {
        return $this->driver;
    }
    public function merchant(): string
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['merchant'];
    }
    public function apiRequest(): string
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['api']['request'];
    }
    public function callbackUrl(): string
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['api']['callbackUrl'];
    }
    public function amount(): int
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['amount'];
    }
    public function description(): string
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['description'];
    }
    public function timeout(): int
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['timeout'];
    }
    public function retry(): int
    {
        return $this->configReader->sandbox()['drivers'][$this->driver()]['retry'];
    }
}
