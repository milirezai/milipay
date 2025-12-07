<?php

namespace MiliPay\Gateways\Zibal;

use MiliPay\Requester\BasicRequester;
use MiliPay\Response\GatewayResponseHandler;
use MiliPay\ResponseAdapters\ZibalAdapter;
use MiliPay\Support\Contract\Gateway;
use MiliPay\Support\Contract\ResourceData;
use MiliPay\Support\Contract\ResponseAdapterHandler;
use MiliPay\Support\Trait\OptionalData;

class ZibalManager extends BasicRequester implements ResourceData, Gateway
{
    use OptionalData;
    protected string $driver = 'zibal';
    protected string $merchant = 'zibal';

    public function __construct(
        protected GatewayResponseHandler $responseHandler,
        protected ResponseAdapterHandler $adapter
    ){}

    public function amount(int $amount): self
    {
        if ($amount > 0){
            $this->amount = $amount;
            return $this;
        }
       errorHandler()
           ->set('amount must be greater than zero.')
           ->log()
           ->info()
           ->toException();
    }

    public function request(): self
    {
        $this->setDefaultConfig();
        $response = $this->sendRequest();
        $this->response = $response;
        return $this;
    }

    public function verify(): self
    {
        $this->setDefaultConfig();
        $response = $this->sendRequestVerify();
        $this->response = $response;
        return $this;
    }

    public function inquiry(): self
    {
        $this->setDefaultConfig();
        $response = $this->sendRequestInquiry();
        $this->response = $response;
        return $this;
    }
    protected function adapter(): ZibalAdapter
    {
        return $this->adapter->init($this->response);
    }

    public function response():GatewayResponseHandler
    {
        return $this->responseHandler->init($this->adapter());
    }

    public function pay()
    {
        if ($this->response()->isSuccessful())
            return $this->start();
    }
    public function sendRequest(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->getApiRequest(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->buildRequestData()),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return (array)json_decode($response);
    }

    public function sendRequestVerify()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->getApiVerify(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->buildVerifyRequestData()),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return (array)json_decode($response);
    }

    public function start()
    {
        return redirect()
            ->away($this->getApiStart().$this->response()->getPayId());
    }

    public function sendRequestInquiry()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->getApiInquiry(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->buildInquiryRequestData()),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return (array)json_decode($response);
    }

    public function buildRequestData(): array
    {
        $requestData = [
            'merchant' => $this->getMerchant(),
            'amount' => $this->getAmount(),
            'callbackUrl' => $this->getCallbackUrl(),
            'description' => $this->getDescription(),
            'orderId' => $this->getOrderId(),
            'mobile' => $this->getMobile(),
            'nationalCode' => (string) $this->getNationalCode(),
        ];

        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '' && $value != 0;
        });

        return $filteredData;
    }

    public function buildVerifyRequestData(): array
    {
        $requestData = [
            'merchant' => $this->getMerchant(),
            'trackId' => $this->getPayId()
        ];
        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '' && $value != 0;
        });

        return $filteredData;
    }

    public function buildInquiryRequestData(): array
    {
        $requestData = [
            'merchant' => $this->getMerchant(),
            'trackId' => $this->getPayId()
        ];
        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '' && $value != 0;
        });

        return $filteredData;
    }
}
