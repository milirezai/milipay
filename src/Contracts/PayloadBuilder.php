<?php

namespace Mili\Milipay\Contracts;

interface PayloadBuilder
{
    public function request(DataExtract $data);
    public function verify(DataExtract $data);
    public function inquiry(DataExtract $data);
}
