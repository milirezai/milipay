<?php

namespace Mili\Milipay;

use Mili\Milipay\Invoice\Invoice;

class Milipay
{
    protected Invoice $invoice;
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    public function invoice()
    {
        return $this->invoice->builder();
    }

}
