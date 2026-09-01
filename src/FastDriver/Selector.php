<?php

namespace Mili\Milipay\FastDriver;

use Mili\Milipay\FastDriver\Config\ConfigReader;

class Selector
{
    public function __construct(
        protected readonly ConfigReader $configReader
    ){}
    public function select()
    {
    }
}
