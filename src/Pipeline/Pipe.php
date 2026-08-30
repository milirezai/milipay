<?php

namespace Mili\Milipay\Pipeline;

use Mili\Milipay\Facades\Registry;
use Illuminate\Pipeline\Pipeline;

class Pipe
{

    public function data(mixed $dataObject)
    {
        return app(Pipeline::class)
            ->send($dataObject)
            ->through(Registry::getPipes())
            ->via('handle')->thenReturn();
    }
}
