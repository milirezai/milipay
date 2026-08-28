<?php

namespace Mili\Milipay\Invoice\Dto;

use Mili\Milipay\Contracts\DataExtract;
use Mili\Milipay\Contracts\PipelinePay;
use Closure;

class Dto implements DataExtract, PipelinePay
{
    protected mixed $data;

    public function handle($data, Closure $next)
    {
        $this->data = $data;
        return $next($this);
    }
    public function timeout(): int
    {
        return $this->data->getTimeout();
    }
    public function retry(): int
    {
       return $this->data->getRetry();
    }

    public function operation()
    {
        return $this->data->getOperation();
    }

    public function payId()
    {
        return $this->data->getPayId();
    }

    public function driver(): string
    {
        return $this->data->getDriver();
    }

    public function merchant(): string
    {
        return $this->data->getMerchant();
    }

    public function apiRequest(): string
    {
        return $this->data->getApiRequest();
    }

    public function apiStart(): string
    {
        return $this->data->getApiStart();
    }

    public function apiVerify(): string
    {
        return $this->data->getApiVerify();
    }

    public function apiInquiry(): string
    {
        return $this->data->getApiInquiry();
    }

    public function callback(): string
    {
        return $this->data->getCallback();
    }

    public function amount(): int
    {
        return $this->data->getAmount();
    }

    public function description(): string
    {
        return $this->data->getDescription();
    }

    public function orderId(): int
    {
        return $this->data->getOrderId();
    }

    public function email(): string
    {
        return $this->data->getEmail();
    }

    public function mobile(): string
    {
        return $this->data->getMobile();
    }

    public function nationalCode(): int
    {
        return $this->data->getNationalCode();
    }
}
