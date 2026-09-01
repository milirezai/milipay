<?php

namespace Mili\Milipay\FastDriver;
use Mili\Milipay\Milipay;
use Illuminate\Http\Client\ConnectionException;

class Probe
{
    public function __construct(
        protected readonly Milipay $milipay,
        protected readonly Sandbox $sandbox,
        protected readonly Result $result
    ){}

    public function for(string $driver): array
    {
        $sandbox = $this->sandbox->for($driver);

        try {

            $response =  $this->milipay->invoice()
                ->driver($sandbox->driver())
                ->merchant($sandbox->merchant())
                ->apiRequest($sandbox->apiRequest())
                ->callback($sandbox->callbackUrl())
                ->amount($sandbox->amount())
                ->description($sandbox->description())
                ->timeout($sandbox->timeout())
                ->retry($sandbox->retry())
                ->request()->response();
            return  $this->result->init($sandbox->driver(),$response->responseTime())->get();

        }catch (ConnectionException $e) {
            return  $this->result->init($sandbox->driver(),null)->get();
        }

    }
}
