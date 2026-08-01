<?php

namespace Milipay\Contracts;

interface DataExtractContract
{
    public function operation();
    public function payId();
    public function driver(): string;
    public function merchant(): string;

    public function apiRequest(): string;

    public function apiStart(): string;

    public function apiVerify(): string;

    public function apiInquiry(): string;

    public function callback(): string;

    public function amount(): int;

    public function description(): string;

    public function orderId(): int;

    public function email(): string;

    public function mobile(): string;

    public function nationalCode(): int;
    public function timeout(): int;
    public function retry(): int;
}
