<?php

namespace Milipay\Contracts;

interface InvoiceDataBuilderContract
{
    public function request();
    public function verify();
    public function inquiry();
    public function getOperation();
    public function driver(string $driver): self;
    public function getDriver(): string;
    public function merchant(string $merchant): self;
    public function getMerchant(): string;

    public function apiRequest(string $apiRequest): self;
    public function getApiRequest(): string;

    public function apiStart(string $apiStart): self;
    public function getApiStart(): string;

    public function apiVerify(string $apiVerify): self;
    public function getApiVerify(): string;

    public function apiInquiry(string $apiInquiry): self;
    public function getApiInquiry(): string;

    public function callback(string $callbackUrl): self;
    public function getCallback(): string;

    public function amount(int $amount): self;
    public function getAmount(): int;

    public function description(string $description): self;
    public function getDescription(): string;

    public function orderId(int $orderId): self;
    public function getOrderId(): int;

    public function email(string $email): self;
    public function getEmail(): string;

    public function mobile(string $mobile): self;
    public function getMobile(): string;

    public function nationalCode(int $nationalCode): self;
    public function getNationalCode(): int;
    public function payId(mixed $payId): self;
    public function getPayId(): mixed;

    public function apis(string $apiRequest = '', string $apiStart = '', string $apiVerify = '', $callback = '' , $apiInquiry = ''): self;
    public function optional(int $orderId = 0 , string $mobile = '', int $nationalCode = 0 , string $description = ''): self;

    public function when(\Closure $closure): self;
    public function via(string $ifTrue, string $ifFalse = ''): self;
    public function timeout(int $timeout = 5): InvoiceDataBuilderContract;
    public function getTimeout(): int;
    public function retry(int $retry = 3): InvoiceDataBuilderContract;
    public function getRetry(): int;

}
