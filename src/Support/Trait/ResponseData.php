<?php

namespace MiliPay\Support\Trait;

trait ResponseData
{
    protected function get():array
    {
        return $this->response;
    }
    public function successful():bool
    {
        $gateConfig = gateConfig()->driver($this->gateway->driverName())->responseKey();
        $value = responseKeyValuetoArray($gateConfig['successful']);
        return $this->response[$value[0]] === $value[1] ? true : false;
    }

    public function payId(): int
    {
        $gateConfig = gateConfig()->driver($this->gateway->driverName())->responseKey();
        return $this->response[$gateConfig['trackId']];
    }

    public function codeMessage(int $code = null): string | null
    {
        $gateConfig = gateConfig()->driver($this->gateway->driverName());
        if ($code === null){
            $value = responseKeyValuetoArray($gateConfig->responseKey()['result'])['0'];
            $code = $this->response[$value];
        }
        return $gateConfig->codeMessage($code);
    }

    public function result(): bool
    {
        $gateConfig = gateConfig()->driver($this->gateway->driverName())->responseKey();
        $value = responseKeyValuetoArray($gateConfig['result']);
        return $this->response[$value[0]] == $value[1] ? true : false;
    }
}
