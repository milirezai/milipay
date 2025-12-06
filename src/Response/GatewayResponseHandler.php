<?php

namespace MiliPay\Response;

use MiliPay\Support\Contract\ResponseHandler;

class GatewayResponseHandler implements ResponseHandler
{

    protected ResponseAdapterHandler $adapterHandler;
    public function init(object $adapter):static
    {
        $this->adapterHandler = $adapter;
        return $this->adapterHandler;
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
        return $this->getMessage();
    }

    public function getPayId(): int|string
    {
        return $this->adapterHandler->getPayId();
    }

    public function getCodeMessage():string|null
    {
        return $this->adapterHandler->getCodeMessage();
    }
}