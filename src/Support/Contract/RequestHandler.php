<?php

namespace MiliPay\Support\Contract;

interface RequestHandler
{
    public function sendRequest();
    public function sendRequestVerify();
    public function start();
    public function sendRequestInquiry();
}
