<?php

namespace MiliPay\Support\Contract;

interface ResponseHandler
{
    public function toJson();
    public function toArray();
    public function init(array $response, object $gateway):self;
}
