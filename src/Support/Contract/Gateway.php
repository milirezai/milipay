<?php

namespace MiliPay\Support\Contract;

use MiliPay\Response\GatewayResponseHandler;

interface Gateway
{
    public function amount(int $amount):self;
    public function request():self;
    public function verify():self;
    public function inquiry():self;
    public function response():GatewayResponseHandler;
    public function pay();
}
