<?php

namespace Milipay\Contracts;

interface PayloadBuilderContract
{
    public function request(DataExtractContract $data);
    public function verify(DataExtractContract $data);
    public function inquiry(DataExtractContract $data);
}
