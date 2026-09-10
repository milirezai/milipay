<?php

namespace Mili\Milipay\Probe;
use Illuminate\Http\Client\ConnectionException;
use Mili\Milipay\Milipay;

class Probe
{
    public function __construct(
        protected readonly Sandbox $sandbox,
        protected readonly Result $result
    ){}

    public function for(string $driver): array
    {
        $sandbox = $this->sandbox->for($driver);

        try {

            $pay =  app(Milipay::class)->invoice()
                ->driver($sandbox->driver())
                ->merchant($sandbox->merchant())
                ->apiRequest($sandbox->apiRequest())
                ->callback($sandbox->callbackUrl())
                ->amount($sandbox->amount())
                ->description($sandbox->description())
                ->timeout($sandbox->timeout())
                ->retry($sandbox->retry())
                ->request();
            return  $this->result->init($sandbox->driver(),$pay->response()->responseTime())->get();

        }catch (ConnectionException $e) {
            return  $this->result->init($sandbox->driver(),null)->get();
        }

    }
}
