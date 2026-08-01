<?php

namespace Milipay\Invoice;

use Milipay\Invoice\Builder\Builder;

class Invoice
{
    public function __construct(protected readonly Builder $builder)
    {}
    public function builder()
    {
        return $this->builder;
    }

}
