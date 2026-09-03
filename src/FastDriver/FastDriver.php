<?php

namespace Mili\Milipay\FastDriver;

use Mili\Milipay\Exceptions\MilipayException;

class FastDriver
{
    public function __construct(
        protected readonly Probe $probe,
        protected readonly ConfigReader $configReader,
        protected readonly Selector $selector,
        protected readonly Storage $storage
    ){
        if (! $this->configReader->enabled())
            throw new MilipayException('feature fast driver not enable');
        $this->storage->defaultDisk()->refresh();
    }    
    public function fasts()
    {

    }
    protected function probes(): void
    {
        $result = [];
        foreach ($this->configReader->sandboxDrivers() as $driver){
            for ($i=0; $this->configReader->numberOfProbePerDriver() >= $i;$i++){
                $result[$driver][] = $this->probe->for($driver)['time'];
            }
        }
         $this->storage->defaultDisk()->save($result);
    }
    protected function compare()
    {

    }

}
