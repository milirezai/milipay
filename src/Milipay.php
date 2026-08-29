<?php

namespace Mili\Milipay;

use Mili\Milipay\Invoice\Invoice;

class Milipay
{
    public function __construct(
        public readonly Invoice $invoice
    ){}

    public function invoice()
    {
        return $this->invoice->builder();
    }

}
