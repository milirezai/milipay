<?php

namespace Mili\Milipay\PayloadBuilders;

use Mili\Milipay\Contracts\DataExtract;
use Mili\Milipay\Contracts\PayloadBuilder;

class ZarinpalPayloadBuilder implements PayloadBuilder
{

    public function request(DataExtract $data)
    {
        $dataTransmitted = [
            'merchant_id' => $data->merchant(),
            'amount' => $data->amount(),
            'callback_url' => $data->callback(),
            'description' => $data->description(),
            'email' => $data->email(),
            'mobile' => $data->mobile(),
            'nationalCode' => $data->nationalCode(),
            'order_id' => $data->orderId()
        ];
        return $this->resolveFilter($dataTransmitted);
    }

    public function verify(DataExtract $data)
    {
        $dataTransmitted = [
            'merchant_id' => $data->merchant(),
            'amount' => $data->amount(),
            'authority' => $data->payId(),
        ];
        return $this->resolveFilter($dataTransmitted);
    }

    public function inquiry(DataExtract $data)
    {
        $dataTransmitted = [
            'merchant_id' => $data->merchant(),
            'authority' => $data->payId(),
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
