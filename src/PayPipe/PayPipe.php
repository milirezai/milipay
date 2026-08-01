<?php

namespace Milipay\PayPipe;

use Milipay\Facades\MilipayRegistry;
use Illuminate\Pipeline\Pipeline;

class PayPipe
{

    public function data(mixed $dataObject)
    {
        return app(Pipeline::class)
            ->send($dataObject)
            ->through(MilipayRegistry::getPipes())
            ->via('handle')->thenReturn();
    }
}
