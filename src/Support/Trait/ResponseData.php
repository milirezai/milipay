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
        if ($this->gateway->driverName() === 'zarinpal'){
            $data = (array)$this->response['data'];
            return $data[$value[0]] === $value[1] ? true : false;
        }
        return $this->response[$value[0]] === $value[1] ? true : false;
    }


   public function payId(): int | string
    {
         $gateConfig = gateConfig()->driver($this->gateway->driverName())->responseKey();
        if ($this->gateway->driverName() === 'zarinpal'){
            $data = (array)$this->response['data'];
            return $data[$gateConfig['payId']];
        }
         return $this->response[$gateConfig['payId']];
    }

    public function codeMessage(int $code = null): string | null
    {
       $gateConfig = gateConfig()->driver($this->gateway->driverName());
        $value = responseKeyValuetoArray($gateConfig->responseKey()['result'])['0'];

        if (empty($code)){
            if ($this->gateway->driverName() === 'zarinpal'){
                $data = (array) $this->toArray()['data'];
                $code = $data[$value];
            }else{
                $code = $this->response[$value];
            }
        }
        return $gateConfig->codeMessage($code);
    }

    public function result(): bool
    {
        $gateConfig = gateConfig()->driver($this->gateway->driverName())->responseKey();
        $value = responseKeyValuetoArray($gateConfig['result']);
        if ($this->gateway->driverName() === 'zarinpal'){
            $data = (array) $this->toArray()['data'];
            return $data[$value[0]] == $value[1] ? true : false;
        }
        return $this->response[$value[0]] == $value[1] ? true : false;
    }
}
