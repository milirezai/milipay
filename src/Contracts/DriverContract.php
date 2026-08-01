<?php

namespace Milipay\Contracts;

interface DriverContract
{
    public function request(DataExtractContract $data): self;
    public function verify(DataExtractContract $data): self;
    public function inquiry(DataExtractContract $data): self;
    public function response(): ResponseHandlerContract;
    public function start();
    public function pay();
}
