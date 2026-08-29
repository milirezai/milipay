<?php

namespace Mili\Milipay\Invoice;

class Invoice
{
    public function __construct(public readonly Builder $builder)
    {}
    public function builder()
    {
        return $this->builder;
    }
}
