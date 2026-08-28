<?php

namespace Mili\Milipay\PayPipe;

use Mili\Milipay\Facades\MilipayRegistry;
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
