<?php

namespace Mili\Milipay\Contracts;
use Closure;

interface PayPipeline
{
    public function handle($data, Closure $next);
}
