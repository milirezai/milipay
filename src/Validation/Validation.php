<?php

namespace Mili\Milipay\Validation;

use Closure;
use Mili\Milipay\Contracts\PayPipeline;

class Validation implements PayPipeline
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