<?php

namespace MiliPay\Config;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ConfigGateway
{
    public string $filePath;
    public string $driver;

    public function setFileConfigPath(): self
    {
        $path = __DIR__.'/../../pay.php';
        $this->filePath = $path;
        return $this;
    }

    public function getFileConfigPath(): string
    {
        return $this->filePath;
    }

    public function driver(string $driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    public function all():array
    {
        $driverConfigContent = config('pay.gateways.'.$this->driver);
        return $driverConfigContent;
    }
    public function apis():array
    {
        $apis = $this->all()['api'];
        return $apis;
    }

    public function settings():array
    {
        $settings = $this->all()['settings'];
        return $settings;
    }

    public function status():bool
    {
        $status = $this->all()['status'];
        return $status;
    }

    public function manager():string
    {
        $manager = $this->all()['manager'];
        return $manager;
    }

    public function codeMessage(int $code):string|null
    {
        $codes = $this->all()['codeMessage'];
        if (Arr::has($codes,$code))
            return Arr::get($codes,$code);
        else
            return null;
    }

    public function name():string
    {
        return $this->driver;
    }

    public function drivers():array
    {
        $drivers = config('pay.drivers');
        return $drivers;
    }

    public function has():bool
    {
        return Arr::has($this->drivers(),$this->driver);
    }

    public function defaultDriver():string
    {
        if (!File::exists(config_path('pay.php')))
            errorHandler()
                ->set('To get the payment driver configuration, please publish the config file first.')
                ->log()
                ->info()
                ->toException();
        return config('pay.default');
    }

    public function responseKey():array
    {
        $key = $this->all()['responseKey'];
        return $key;
    }
    private function config()
    {
        if (!File::exists(config_path('pay.php')))
            errorHandler()
                ->set('To get the payment driver configuration, please publish the config file first.')
                ->log()
                ->info()
                ->toException();
    }
}

