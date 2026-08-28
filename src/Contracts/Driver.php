<?php

namespace Mili\Milipay\Contracts;

interface Driver
{
    public function request(DataExtract $data): self;
    public function verify(DataExtract $data): self;
    public function inquiry(DataExtract $data): self;
    public function response(): ResponseHandler;
    public function start();
    public function pay();
}
