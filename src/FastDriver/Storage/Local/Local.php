<?php

namespace Mili\Milipay\FastDriver\Storage\Local;
use Mili\Milipay\FastDriver\Config\ConfigReader;
use Mili\Milipay\FastDriver\Contracts\Storage;
use Illuminate\Support\Facades\File;

class Local implements Storage
{
    public function __construct(
        protected readonly ConfigReader $configReader
    ){}
    public function save(array $data): void
    {
        file_put_contents($this->resoleDiskRoot(),PHP_EOL.json_encode($data),FILE_APPEND);
    }
    private function resoleDiskRoot(): string
    {
        $path = $this->configReader->storages()['disks']['local']['root'];
        if (! file_exists($path))
            fopen($path,'a');
        return $path;
    }
    public function get()
    {

    }
}
