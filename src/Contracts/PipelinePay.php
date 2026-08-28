<?php

namespace Mili\Milipay\Contracts;
use Closure;

interface PipelinePay
{
    public function handle($data, Closure $next);
}
