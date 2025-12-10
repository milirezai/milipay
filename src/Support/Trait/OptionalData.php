<?php

namespace MiliPay\Support\Trait;

use MiliPay\ErrorHandler\PaymentErrorHandler;
use Illuminate\Support\Arr;

trait OptionalData
{
    public function merchant(string $merchant): self
    {
        if ($merchant != ''){
            $this->merchant = $merchant;
            return $this;
        }
        errorHandler()
            ->set('merchant required')
            ->log()
            ->info();
        return $this;
    }
    public function getMerchant():string
    {
        return $this->merchant;
    }

    public function apiRequest(string $url): self
    {
        if ($url != ''){
            $this->apiRequest = $url;
            return $this;
        }
        errorHandler()
            ->set('apiRequest required')
            ->log()
            ->info();
        return $this;
    }
    protected function getApiRequest():string
    {
        return $this->apiRequest;
    }

    public function apiStart(string $url): self
    {
        if ($url != ''){
            $this->apiStart = $url;
            return $this;
        }
        errorHandler()
            ->set('apiStart required')
            ->log()
            ->info();
        return $this;
    }
    protected function getApiStart():string
    {
        return $this->apiStart;
    }

    public function apiVerify(string $url): self
    {
        if ($url != ''){
            $this->apiVerify = $url;
            return $this;
        }
        errorHandler()
            ->set('apiVerify required')
            ->log()
            ->info();
        return $this;
    }
    protected function getApiVerify():string
    {
        return $this->apiVerify;
    }

    public function apiInquiry(string $url): self
    {
        if ($url != ''){
            $this->apiInquiry = $url;
            return $this;
        }
        errorHandler()
            ->set('apiInquiry required')
            ->log()
            ->info();
        return $this;
    }
    protected function getApiInquiry():string
    {
        return $this->apiInquiry;
    }
    public function callbackUrl(string $callbackUrl): self
    {
        if ($callbackUrl != ''){
            $this->callbackUrl = $callbackUrl;
            return $this;
        }
        errorHandler()
            ->set('apiInquiry required')
            ->log()
            ->info();
        return $this;
    }
    protected function getCallbackUrl():string
    {
        return $this->callbackUrl;
    }

    public function description(string $description): self
    {
        if ($description != ''){
            $this->description = $description;
            return $this;
        }
        errorHandler()
            ->set('description required')
            ->log()
            ->info();
        return $this;
    }
    protected function getDescription():string
    {
        return $this->description;
    }

    public function orderId(int $orderId): self
    {
        if ($orderId <= 0){
            errorHandler()
                ->set('orderId must be greater than zero.')
                ->log()
                ->info();
            return $this;
        }
        $this->orderId = $orderId;
        return $this;
    }
    protected function getOrderId():int
    {
        return $this->orderId;
    }

    public function mobile(string $mobile): self
    {
        if ($mobile != ''){
            $this->mobile = $mobile;
            return $this;
        }
        errorHandler()
            ->set('mobile required')
            ->log()
            ->info();
        return $this;
    }
    protected function getMobile():string
    {
        return $this->mobile;
    }

    public function nationalCode(int $nationalCode): self
    {
        if (strlen($nationalCode) === 10){
            $this->nationalCode = $nationalCode;
            return $this;
        }
        errorHandler()
            ->set('The national code must be 10 digits.')
            ->log()
            ->info();
        return $this;
    }
    protected function getNationalCode():int
    {
        return $this->nationalCode;
    }

    public function payId(int|string $payId):static
    {
        if (empty($payId)){
            errorHandler()
                ->set('trackId must be greater than zero.')
                ->log()
                ->info();
            return $this;
        }
        $this->payId = $payId;
        return $this;
    }
    protected function getPayId():int|string
    {
        return $this->payId;
    }

    protected function getAmount():int
    {
        return $this->amount;
    }
    public function apis(
        string $apiRequest = '', string $apiStart = '',
        string $apiVerify = '', $callback = '' , $apiInquiry = ''
    ):static
    {
          !empty($apiRequest) ? $this->apiRequest($apiRequest) :'';
          !empty($apiStart) ? $this->apiStart($apiStart) :'';
          !empty($apiVerify) ? $this->apiVerify($apiVerify) :'';
          !empty($apiInquiry) ? $this->apiInquiry($apiInquiry) :'';
          !empty($callback) ? $this->callbackUrl($callback) :'';

        return $this;
    }
    public function optional(
        int $orderId = 0 , string $mobile = '',
        int $natinalCode = 0 , string $description = ''
    ):static
    {
        $orderId > 0 ? $this->orderId($orderId) :'';
        !empty($mobile) ? $this->mobile($mobile) :'';
        strlen($natinalCode) > 0 ? $this->nationalCode($natinalCode) :'';
        !empty($description) ? $this->description($description) :'';
        return $this;
    }

    public function setDefaultConfig():void
    {
        $driver = gateConfig()->driver($this->driver);
        $this->getApiRequest() === '' ? $this->apiRequest($driver->apis()['apiRequest']) :$this->getApiRequest();
        $this->getApiStart() === '' ? $this->apiStart($driver->apis()['apiStart']) :$this->getApiStart();
        $this->getApiVerify() === '' ? $this->apiVerify($driver->apis()['apiVerify']) :$this->getApiVerify();
        $this->getApiInquiry() === '' ? $this->apiInquiry($driver->apis()['apiInquiry']) :$this->getApiInquiry();
        $this->getMerchant() === '' ? $this->merchant($driver->settings()['merchant']) :$this->getMerchant();
        $this->getCallbackUrl() === '' ? $this->callbackUrl($driver->settings()['callbackUrl']) :$this->getCallbackUrl();
    }

    public function driverName(): string
    {
        return $this->driver;
    }

    public function email(string $email): self
    {
        if ($email != ''){
            $this->email = $email;
            return $this;
        }
        errorHandler()
            ->set('email required')
            ->log()
            ->info();
        return $this;
    }
    protected function getEmail():string
    {
        return $this->email;
    }
}
