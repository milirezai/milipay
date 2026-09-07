<?php

namespace Mili\Milipay\FastDriver;

use Mili\Milipay\Exceptions\MilipayException;
use Mili\Milipay\Probe\ConfigReader;
use Mili\Milipay\Probe\Probe;
use Mili\Milipay\FastDriver\Storage\Storage;

class FastDriver
{
    public function __construct(
        protected readonly Probe $probe,
        protected readonly ConfigReader $configReader,
        protected readonly Selector $selector,
        protected readonly Storage $storage
    ){}
        
    public function fasts(): string
    {
        return $this->selector->fast();
    }
    public function probes(): void
    {
        $result = [];
        $this->storage->defaultDisk()->refresh();
        foreach ($this->configReader->sandboxDrivers() as $driver){
            for ($i=0; $this->configReader->numberOfProbePerDriver() >= $i;$i++){
                $result[$driver][] = $this->probe->for($driver)['time'];
            }
        }
         $this->storage->defaultDisk()->save($result);
    }
    public function selectDriver(string $default = null): string
    {
        if ($this->configReader->enabled())
            return $this->fasts();
        if ($default)
            return $default;
        throw  new MilipayException('error in select driver');
    }
}
