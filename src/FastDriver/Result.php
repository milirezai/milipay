<?php

namespace Mili\Milipay\FastDriver;

class Result
{
    protected string $driver;
    protected ?int $time;
    public function init(string $driver, ?int $time): self
    {
        $this->driver = $driver;
        $this->time = $time;
        return $this;
    }
    public function get(): array
    {
        return
            [
                'driver' => $this->driver,
                'time' => $this->time
            ];
    }
}
