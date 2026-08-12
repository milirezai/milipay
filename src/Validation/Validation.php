<?php

namespace Milipay\Validation;

use Closure;
use Milipay\Contracts\PipelinePayContract;

class Validation implements PipelinePayContract
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