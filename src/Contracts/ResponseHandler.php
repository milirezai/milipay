<?php

namespace Mili\Milipay\Contracts;

interface ResponseHandler
{
    public function init(mixed $response):self;

    public function toJson();

    public function toArray();

    public function isSuccessful():bool;

    public function isFailed():bool;

    public function getMessage():string;

    public function getPayId():int|string;

    public function getTranslateResponseCode():string|null;
    public function responseTime(): float;
}
