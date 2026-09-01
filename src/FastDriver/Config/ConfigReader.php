<?php

namespace Mili\Milipay\FastDriver\Config;

class ConfigReader
{
    protected array $config = [];
    public function __construct()
    {
        $this->config = require __DIR__.'/config.php';
    }
    public function read(): array
    {
        return $this->config;
    }
    public function sandbox(): array
    {
        return $this->read()['sandbox'];
    }
    public function storages(): array
    {
        return $this->read()['storages'];
    }
}
