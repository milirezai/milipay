<?php

namespace Mili\Milipay\Invoice;

use Mili\Milipay\Contracts\InvoiceDataBuilder;
use Mili\Milipay\Pipeline\Pipe;

class Builder implements InvoiceDataBuilder
{
    protected string $driver = '';
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
    protected string $operation = '';
    protected mixed $payId = '';
    protected \Closure $closure;
    protected int $timeout = 0;
    protected int $retry = 0;

    public function __construct(protected readonly Pipe $payPipe)
    {}

    public function request()
    {
        $this->operation = 'request';
        return $this->payPipe->data($this);
    }
    public function verify()
    {
        $this->operation = 'verify';
        return $this->payPipe->data($this);
    }
    public function inquiry()
    {
        $this->operation = 'inquiry';
        return $this->payPipe->data($this);
    }
    public function when(\Closure $closure): InvoiceDataBuilder
    {
        $this->closure = $closure;
        return $this;
    }
    public function via(string $ifTrue, string $ifFalse = ''): InvoiceDataBuilder
    {
        $closure = call_user_func($this->closure);
        if ($closure)
            $this->driver($ifTrue);
        else{
            $ifFalse = empty($ifFalse) ? '' : $ifFalse;
            $this->driver($ifFalse);
        }
        return $this;
    }
    public function timeout(int $timeout = 5): InvoiceDataBuilder
    {
        $this->timeout = $timeout;
        return $this;
    }
    public function getTimeout(): int
    {
        return $this->timeout;
    }
    public function retry(int $retry = 3): InvoiceDataBuilder
    {
        $this->retry = $retry;
        return $this;
    }
    public function getRetry(): int
    {
        return $this->retry;
    }

    public function driver(string $driver): InvoiceDataBuilder
    {
        $this->driver = $driver;
        return $this;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }
    public function getOperation()
    {
        return $this->operation;
    }
    public function payId(mixed $payId): InvoiceDataBuilder
    {
        $this->payId = $payId;
        return $this;
    }
    public function getPayId(): mixed
    {
        return $this->payId;
    }

    public function merchant(string $merchant): InvoiceDataBuilder
    {
        $this->merchant = $merchant;
        return $this;
    }

    public function getMerchant(): string
    {
        return $this->merchant;
    }

    public function apiRequest(string $apiRequest): InvoiceDataBuilder
    {
        $this->apiRequest = $apiRequest;
        return $this;
    }

    public function getApiRequest(): string
    {
       return $this->apiRequest;
    }

    public function apiStart(string $apiStart): InvoiceDataBuilder
    {
       $this->apiStart = $apiStart;
       return $this;
    }

    public function getApiStart(): string
    {
        return $this->apiStart;
    }

    public function apiVerify(string $apiVerify): InvoiceDataBuilder
    {
        $this->apiVerify = $apiVerify;
        return $this;
    }

    public function getApiVerify(): string
    {
        return $this->apiVerify;
    }

    public function apiInquiry(string $apiInquiry): InvoiceDataBuilder
    {
        $this->apiInquiry = $apiInquiry;
        return $this;
    }

    public function getApiInquiry(): string
    {
        return $this->apiInquiry;
    }

    public function callback(string $callbackUrl): InvoiceDataBuilder
    {
       $this->callbackUrl = $callbackUrl;
       return $this;
    }

    public function getCallback(): string
    {
        return $this->callbackUrl;
    }

    public function amount(int $amount): InvoiceDataBuilder
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function description(string $description): InvoiceDataBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function orderId(int $orderId): InvoiceDataBuilder
    {
       $this->orderId = $orderId;
       return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function email(string $email): InvoiceDataBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function mobile(string $mobile): InvoiceDataBuilder
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function getMobile(): string
    {
       return $this->mobile;
    }

    public function nationalCode(int $nationalCode): InvoiceDataBuilder
    {
        $this->nationalCode = $nationalCode;
        return $this;
    }

    public function getNationalCode(): int
    {
        return $this->nationalCode;
    }

    public function apis(string $apiRequest = '', string $apiStart = '', string $apiVerify = '', $callback = '', $apiInquiry = ''): InvoiceDataBuilder
    {
        !empty($apiRequest)  ? $this->apiRequest($apiRequest) :'';
        !empty($apiStart) ? $this->apiStart($apiStart) :'';
        !empty($apiVerify) ? $this->apiVerify($apiVerify) :'';
        !empty($apiInquiry) ? $this->apiInquiry($apiInquiry) :'';
        !empty($callback) ? $this->callback($callback) :'';

        return $this;
    }

    public function optional(int $orderId = 0, string $mobile = '', int $nationalCode = 0, string $description = ''): InvoiceDataBuilder
    {
        $orderId > 0 ? $this->orderId($orderId) : '';
        !empty($mobile) ? $this->mobile($mobile) :'';
        strlen($nationalCode) > 0 ? $this->nationalCode($nationalCode) :'';
        !empty($description) ? $this->description($description) :'';
        return $this;
    }

}
