<?php

namespace MiliPay\Response;

use MiliPay\Support\Contract\ResponseHandler;
use MiliPay\Support\Trait\ResponseData;

class GatewayResponseHandler implements ResponseHandler
{
    use ResponseData;
    protected array $response;
    protected object $gateway;

    public function toJson()
    {
        return json_encode($this->getResponse());
    }

    public function toArray():array
    {
        return $this->getResponse();
    }

    public function init(array $response, object $gateway): self
    {
        $this->response = $response;
        $this->gateway = $gateway;
        return $this;
    }
}
