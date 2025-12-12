<?php

namespace MiliPay\Response;

use MiliPay\Support\Contract\ResponseHandler;
use Closure;

class GatewayResponseHandler implements ResponseHandler
{

    protected $adapterHandler;
    public function init(object $adapter):static
    {
        $this->adapterHandler = $adapter;
        return $this;
    }

    public function toJson()
    {
        return $this->adapterHandler->toJson();
    }

    public function toArray()
    {
        return $this->adapterHandler->toArray();
    }

    public function isSuccessful(): bool
    {
        return $this->adapterHandler->isSuccessful();
    }

    public function isFailed(): bool
    {
        return $this->adapterHandler->isFailed();
    }

    public function getMessage(): string
    {
        return $this->adapterHandler->getMessage();
    }

    public function getPayId(): int|string
    {
        return $this->adapterHandler->getPayId();
    }

    public function getCodeMessage():string|null
    {
        return $this->adapterHandler->getCodeMessage();
    }

    public function whenSuccess(Closure $success, Closure $failed)
    {
        if ($this->isSuccessful()){
            call_user_func($success,$this);
        }
        else{
            call_user_func($failed,$this);
        }
    }

    public function whenFailed(Closure $failed, Closure $success)
    {
        if ($this->isFailed()){
            call_user_func($failed,$this);
        }
        else{
            call_user_func($success,$this);
        }
    }
}