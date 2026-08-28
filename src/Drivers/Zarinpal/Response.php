<?php

namespace Mili\Milipay\Drivers\Zarinpal;

use Mili\Milipay\Contracts\ResponseHandler;

class Response implements ResponseHandler
{
    protected mixed $response;
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
        return $this->getMessage() == 'Success' ? true : false;
    }

    public function isFailed(): bool
    {
        return !$this->isSuccessful();
    }

    public function getMessage(): string
    {
        $data = (array)$this->toArray()['data'];
        $dataMessageError = (array)$this->toArray()['errors'];
        if (empty($data)){
            $message = $dataMessageError;
        }else{
            $message = $data;
        }
        return $message['message'];
    }

    public function getPayId(): int|string
    {
        $data = (array)$this->toArray()['data'];
        return $data['authority'];
    }

    public function getCodeMessage(): string|null
    {
        $codes = pay_config('drivers.zarinpal.codeMessage');
        $data = (array)$this->toArray()['data'];
        $code = $data['code'];
        return $codes[$code];
    }
}
