<?php

namespace Mili\Milipay\FastDriver\Storage;

use Illuminate\Support\Facades\File;
use Mili\Milipay\Contracts\Storage;
use Mili\Milipay\FastDriver\ConfigReader;

class Local implements Storage
{
    public function __construct(
        protected readonly ConfigReader $configReader
    ){}
    public function save(array $data): void
    {
        file_put_contents($this->diskRoot(),PHP_EOL.json_encode($data),FILE_APPEND);
    }
    private function diskRoot(): string
    {
        $path = $this->configReader->storages()['disks']['local']['root'];
        if (! file_exists($path))
            touch($path);
        return $path;
    }

    public function get(): array
    {
       return (array) File::lines($this->diskRoot())->filter(function ($line){
            return $line != null;
        })->map(function ($line){
            return (array) json_decode($line);
       })->first();        
    }
    public function refresh(): void
    {
        File::put($this->diskRoot(),'');
    }
}
