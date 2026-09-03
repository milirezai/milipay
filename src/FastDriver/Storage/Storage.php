<?php

namespace Mili\Milipay\FastDriver\Storage;

use Mili\Milipay\Contracts\Storage as StorageContract;
use Mili\Milipay\Exceptions\MilipayException;
use Mili\Milipay\FastDriver\ConfigReader;
use Mili\Milipay\FastDriver\Storage\Local;

class Storage
{
    public function __construct(
        protected readonly ConfigReader $configReader
    ){}

    public function defaultDisk(): StorageContract
    {
        return match ($this->configReader->storages()['default']){
            'local' => app(Local::class),
            default => throw new MilipayException('fast driver storage disk not supported'),
        };
    }
}
