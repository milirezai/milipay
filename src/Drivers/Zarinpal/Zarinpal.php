<?php

namespace Mili\Milipay\Drivers\Zarinpal;

use Mili\Milipay\Contracts\DataExtract;
use Mili\Milipay\Contracts\Driver;
use Mili\Milipay\Contracts\ResponseHandler;
use Mili\Milipay\Contracts\PayloadBuilder;
use Mili\Milipay\Exceptions\MilipayException;
use Mili\Milipay\Requester\Requester;
use Mili\Milipay\Response\PayResult;

class Zarinpal implements Driver
{
    public string $name = 'zarinpal';
    private mixed $response;
    private DataExtract $data;

    public function __construct(
        protected readonly PayloadBuilder  $payloadBuilder,
        protected readonly ResponseHandler $responseHandler,
        protected readonly PayResult               $centralResponseManager,
        protected readonly Requester               $requester
    ){}

    public function request(DataExtract $data): self
    {
        $this->data = $data;
        $payloadBuilderData = $this->payloadBuilder->request($this->data);
        $this->resolve(
            api: $this->data->apiRequest(), payloadBuilderData: $payloadBuilderData
        );
        return $this;
    }

    public function verify(DataExtract $data): self
    {
        $this->data = $data;
        $payloadBuilderData = $this->payloadBuilder->verify($this->data);
        $this->resolve(
            api: $this->data->apiVerify(), payloadBuilderData: $payloadBuilderData
        );
        return $this;
    }

    public function inquiry(DataExtract $data): self
    {
        $this->data = $data;
        $payloadBuilderData = $this->payloadBuilder->inquiry($this->data);
        $this->resolve(
            api: $this->data->apiInquiry(), payloadBuilderData: $payloadBuilderData
        );
        return $this;
    }
    private function resolve(string $api, mixed $payloadBuilderData): void
    {
        $httpResponse = $this->requester->post(
            timeout: $this->data->timeout(), retry: $this->data->retry(),
            api: $api, data: $payloadBuilderData
        );
        $this->response = $httpResponse;
    }

    private function adapt(): ResponseHandler
    {
        return $this->responseHandler->init($this->response);
    }

    public function response(): ResponseHandler
    {
        return $this->centralResponseManager->init($this->adapt());
    }

    public function start()
    {
        return redirect()->away($this->data->apiStart().$this->adapt()->getPayId());
    }

    public function pay()
    {
        if ($this->adapt()->isSuccessful())
            return $this->start();
        throw new MilipayException('request not success');
    }
}
