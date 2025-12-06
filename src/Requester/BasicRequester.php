<?php

namespace MiliPay\Requester;

use MiliPay\Support\Contract\RequestHandler;
use MiliPay\Support\Contract\ResponseAdapterHandler;

abstract class BasicRequester implements RequestHandler
{
    protected string $driver;
    protected string $merchant = '';
    protected string $apiRequest = '';
    protected string $apiStart = '';
    protected string $apiVerify = '';
    protected string $apiInquiry = '';
    protected string $callbackUrl = '';
    protected int $amount = 0;
    protected string $description = '';
    protected int $orderId = 0;
    protected string $email = '';
    protected string $mobile = '';
    protected int $nationalCode = 0;
    protected int|string $payId = 0;
    protected array $response = [];
    abstract protected function adapter():ResponseAdapterHandler;
    abstract public function sendRequest();
    abstract public function sendRequestVerify();
    abstract public function start();
    abstract public function sendRequestInquiry();
}
