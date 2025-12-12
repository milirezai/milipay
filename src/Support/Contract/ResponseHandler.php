<?php

namespace MiliPay\Support\Contract;

interface ResponseHandler
{
    public function init(object $adapter):static;

    public function toJson();

    public function toArray();

    public function isSuccessful():bool;

    public function isFailed():bool;

    public function getMessage():string;

    public function getPayId():int|string;

    public function getCodeMessage():string|null;
}
