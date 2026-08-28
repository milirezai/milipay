<?php

namespace Mili\Milipay\Invoice;

use Closure;
use Mili\Milipay\Contracts\PipelinePay;

class ResolveData implements PipelinePay
{
    private mixed $data;

    public function handle($data, Closure $next)
    {
        $this->data = $data;
        $this->resolve();
        return $next($data);
    }
    public function resolve(): void
    {
        // resolve driver
        if (empty($this->data->getDriver()))
            $this->data->driver(pay_config('defaultDriver'));
        // resolve api request
        if (empty($this->data->getApiRequest()))
            $this->data->apiRequest(pay_config('drivers.'.$this->data->getDriver().'.api.request'));
        // resolve api start
        if (empty($this->data->getApiStart()))
            $this->data->apiStart(pay_config('drivers.'.$this->data->getDriver().'.api.start'));
        // resolve api verify
        if (empty($this->data->getApiVerify()))
            $this->data->apiVerify(pay_config('drivers.'.$this->data->getDriver().'.api.verify'));
        // resolve api inquiry
        if (empty($this->data->getApiInquiry()))
            $this->data->apiInquiry(pay_config('drivers.'.$this->data->getDriver().'.api.inquiry'));
        // resolve merchant
        if (empty($this->data->getMerchant()))
            $this->data->merchant(pay_config('drivers.'.$this->data->getDriver().'.merchant'));
        // resolve callbackUrl
        if (empty($this->data->getCallback()))
            $this->data->callback(pay_config('drivers.'.$this->data->getDriver().'.api.callbackUrl'));
        // resolve timeout
        if ($this->data->getTimeout() < 1)
            $this->data->timeout(pay_config('drivers.'.$this->data->getDriver().'.timeout'));
        // resolve retry
        if ($this->data->getRetry() < 1)
            $this->data->retry(pay_config('drivers.'.$this->data->getDriver().'.retry'));
    }
}
