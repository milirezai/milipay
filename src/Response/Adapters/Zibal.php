<?php

namespace Milipay\Response\Adapters;

use Milipay\Contracts\ResponseHandlerContract;

class Zibal implements ResponseHandlerContract
{
    protected array $response;

    public function init(mixed $response): self
    {
        $this->response = $response;
        return $this;
    }
    public function responseTime(): float
    {
        $response_time = $this->toArray()['response_time_ms'];
        return $response_time;
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
        return !$this->isSuccessful();
    }

    public function getMessage(): string
    {
        return $this->toArray()['message'];
    }

    public function getPayId(): int|string
    {
        return $this->toArray()['trackId'];
    }

    public function getCodeMessage(): string|null
    {
        $codes = pay_config('drivers.zibal.codeMessage');
        $code = $this->toArray()['result'];
        return $codes[$code];
    }
}
