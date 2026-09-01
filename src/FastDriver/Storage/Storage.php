<?php

namespace Mili\Milipay\FastDriver\Storage;

use Mili\Milipay\FastDriver\Storage\Local\Local;
use Mili\Milipay\FastDriver\Storage\Mysql\Mysql;
use Mili\Milipay\FastDriver\Contracts\Storage as StorageContract;
use Mili\Milipay\FastDriver\Config\ConfigReader;

class Storage
{
    public function __construct(
        protected readonly ConfigReader $configReader
    ){}

    public function defaultDisk(): StorageContract
    {
        return match ($this->configReader->storages()['default']){
            'local' => app(Local::class),
            "mysql" => app(Mysql::class)
        };
    }
}
