<?php

namespace Milipay\PayloadBuilders;

use Milipay\Contracts\DataExtractContract;
use Milipay\Contracts\PayloadBuilderContract;

class ZibalPayloadBuilder implements PayloadBuilderContract
{

    public function request(DataExtractContract $data)
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

    public function verify(DataExtractContract $data)
    {
        $dataTransmitted = [
            'merchant' => $data->merchant(),
            'trackId' => $data->payId(),
        ];
        return $this->resolveFilter($dataTransmitted);
    }

    public function inquiry(DataExtractContract $data)
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
