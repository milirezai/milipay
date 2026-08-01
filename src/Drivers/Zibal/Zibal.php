<?php

namespace Milipay\Drivers\Zibal;

use Milipay\Contracts\DataExtractContract;
use Milipay\Contracts\DriverContract;
use Milipay\Contracts\ResponseHandlerContract;
use Milipay\Contracts\PayloadBuilderContract;
use Milipay\Exceptions\MilipayException;
use Milipay\Requester\Requester;
use Milipay\Response\PayResult;

class Zibal implements DriverContract
{
    public string $name = 'zibal';
    private mixed $response;
    private DataExtractContract $data;

    public function __construct(
        protected readonly PayloadBuilderContract  $payloadBuilder,
        protected readonly ResponseHandlerContract $responseHandler,
        protected readonly PayResult               $centralResponseManager,
        protected readonly Requester               $requester,
    ){}

    public function request(DataExtractContract $data): self
    {
        $this->data = $data;
        $payloadBuilderData = $this->payloadBuilder->request($this->data);
        $this->resolve(
            api: $this->data->apiRequest(), payloadBuilderData: $payloadBuilderData
        );
        return $this;
    }

    public function verify(DataExtractContract $data): self
    {
        $this->data = $data;
        $payloadBuilderData = $this->payloadBuilder->verify($this->data);
        $this->resolve(
            api: $this->data->apiVerify(), payloadBuilderData: $payloadBuilderData
        );
        return $this;
    }

    public function inquiry(DataExtractContract $data): self
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

    private function adapt(): ResponseHandlerContract
    {
        return $this->responseHandler->init($this->response);
    }

    public function response(): ResponseHandlerContract
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
