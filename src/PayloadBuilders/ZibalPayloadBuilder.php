<?php

namespace Mili\Milipay\PayloadBuilders;

use Mili\Milipay\Contracts\DataExtract;
use Mili\Milipay\Contracts\PayloadBuilder;

class ZibalPayloadBuilder implements PayloadBuilder
{

    public function request(DataExtract $data)
    {
        $dataTransmitted = [
            'merchant' => $data->merchant(),
            'amount' => $data->amount(),
            'callbackUrl' => $data->callback(),
            'description' => $data->description(),
            'email' => $data->email(),
            'mobile' => $data->mobile(),
            'nationalCode' => $data->nationalCode(),
            'orderId' => $data->orderId()
        ];
        return $this->resolveFilter($dataTransmitted);
    }

    public function verify(DataExtract $data)
    {
        $dataTransmitted = [
            'merchant' => $data->merchant(),
            'trackId' => $data->payId(),
        ];
        return $this->resolveFilter($dataTransmitted);
    }

    public function inquiry(DataExtract $data)
    {
        $dataTransmitted = [
            'merchant' => $data->merchant(),
            'trackId' => $data->payId(),
        ];
        return $this->resolveFilter($dataTransmitted);
    }
    private function resolveFilter(array $data)
    {
        return collect($data)->filter(function ($item){
            return !empty($item) & $item > 0;
        })->toArray();
    }
}
