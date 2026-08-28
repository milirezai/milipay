<?php

namespace Mili\Milipay\Invoice;

class Invoice
{
    public function __construct(protected readonly Builder $builder)
    {}
    public function builder()
    {
        return $this->builder;
    }

}
