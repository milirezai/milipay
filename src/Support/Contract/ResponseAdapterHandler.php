<?php

namespace MiliPay\Support\Contract;

interface ResponseAdapterHandler
{
    public function init(array $response):static;

    public function toJson();

    public function toArray();

    public function isSuccessful():bool;

    public function isFailed():bool;

    public function getMessage():string;

    public function getPayId():int|string;

    public function getCodeMessage():string|null;
}
