<?php

namespace Mili\Milipay\Validation;

use Closure;
use Mili\Milipay\Contracts\PipelinePay;

class Validation implements PipelinePay
{
    public function __construct(
        protected ValidationDataInvoice $validation
    ){}

    public function handle($data, Closure $next)
    {
        $this->validation->validate($data);
        return $next($data);
    }
}