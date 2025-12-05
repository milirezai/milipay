<?php

namespace MiliPay\Support\Contract;

interface GatewayManager
{
    public function gate():Gateway;
}
