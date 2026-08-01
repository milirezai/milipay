<?php

namespace Milipay\Contracts;
use Closure;

interface PipelinePayContract
{
    public function handle($data, Closure $next);
}
