<?php

namespace Milipay\Validation;

use Illuminate\Validation\ValidationException;
use Milipay\Contracts\InvoiceDataBuilderContract;
use Milipay\Exceptions\MilipayException;

class ValidationDataInvoice
{
    protected InvoiceDataBuilderContract $invoice;
    public function validate(InvoiceDataBuilderContract $invoice)
    {
        $this->invoice = $invoice;
        try {
            Validator::validate($this->resolveConvertInputDataToArray(), $this->definingValidationRules());
        }catch (ValidationException $e){
            throw new MilipayException($e->getMessage());
        }
    }
    private function resolveConvertInputDataToArray(): array
    {
        return [
            'driver' => $this->invoice->getDriver(),
            'merchant' => $this->invoice->getMerchant(),
            'apiRequest' => $this->invoice->getApiRequest(),
            'apiStart' => $this->invoice->getApiStart(),
            'apiVerify' => $this->invoice->getApiVerify(),
            'apiInquiry' => $this->invoice->getApiInquiry(),
            'callbackUrl' => $this->invoice->getCallback(),
            'orderId' => $this->invoice->getOrderId(),
            'nationalCode' => $this->invoice->getNationalCode(),
            'timeout' => $this->invoice->getTimeout(),
            'retry' => $this->invoice->getRetry(),
            'amount' => $this->invoice->getAmount(),
            'description' => $this->invoice->getDescription(),
            'email' => $this->invoice->getEmail(),
            'mobile' => $this->invoice->getMobile(),
            'payId' => $this->invoice->getPayId()
        ];
    }
    private function definingValidationRules(): array
    {
        return [
            'driver' => [ 'nullable', 'string', 'in:zibal,zarinpal' ],
            'merchant' => [ 'nullable', 'string' ],
            'apiRequest' => [ 'nullable', 'string', 'url' ],
            'apiStart' => [ 'nullable', 'string', 'url' ],
            'apiVerify' => [ 'nullable', 'string', 'url' ],
            'apiInquiry' => [ 'nullable', 'string', 'url' ],
            'callbackUrl' => [ 'nullable', 'string', 'url'],
            'orderId' => [ 'nullable', 'integer', 'min:1' ],
            'nationalCode' => [ 'nullable', 'integer', 'digits:10' ],
            'timeout' => [ 'nullable', 'integer', 'min:1' ],
            'retry' => [ 'nullable', 'integer', 'min:0', 'max:10' ],
            'amount' => [ 'required', 'integer', 'min:10' ],
            'description' => [ 'nullable', 'string', 'max:200'],
            'email' => [ 'nullable', 'email' ],
            'mobile' => [ 'nullable', 'string', 'regex:/^09\d{9}$/' ],
            'payId' => [ 'nullable', 'max:255' ],
        ];
    }
}