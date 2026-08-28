<?php

namespace Mili\Milipay\Pipeline;

use Mili\Milipay\Facades\MilipayRegistry;
use Illuminate\Pipeline\Pipeline;

class Pipe
{

    public function data(mixed $dataObject)
    {
        return app(Pipe::class)
            ->send($dataObject)
            ->through(MilipayRegistry::getPipes())
            ->via('handle')->thenReturn();
    }
}
