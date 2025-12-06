<?php

namespace MiliPay\ResponseAdapters;

use MiliPay\Support\Contract\ResponseAdapterHandler;

class ZibalAdapter implements ResponseAdapterHandler
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
        return $this->toArray()['message'] == 'success' ? true : false;
    }

    public function isFailed(): bool
    {
        return ! $this->isSuccessful();
    }

    public function getMessage(): string
    {
        return $this->toArray()['message'];
    }

    public function getPayId(): int|string
    {
        return $this->toArray()['trackId'];
    }

    public function getCodeMessage():string|null
    {
        $getCode = gateConfig()->driver('zibal');
        $code = $this->toArray()['result'];
        return $getCode->codeMessage($code);
    }
}