<?php

namespace MiliPay\ResponseAdapters;

use MiliPay\Support\Contract\ResponseAdapterHandler;

class ZarinpalAdapter implements ResponseAdapterHandler
{
    protected array $response;
    public function init(array $response): static
    {
        $this->response = $response;
        return $this;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return $this->response;
    }

    public function isSuccessful(): bool
    {
        $data = (array)$this->toArray()['data'];
        return $data['message'] == 'Success' ? true : false;
    }

    public function isFailed(): bool
    {
       return ! $this->isSuccessful();
    }

    public function getMessage(): string
    {
       $data = (array)$this->toArray()['data'];
       return $data['message'];
    }

    public function getPayId(): int|string
    {
        $data = (array)$this->toArray()['data'];
        return $data['authority'];
    }

    public function getCodeMessage():string|null
    {
        $getCode = gateConfig()->driver('zarinpal');
        $data = (array)$this->toArray()['data'];
        $code = $data['code'];
        return $getCode->codeMessage($code);
    }
}