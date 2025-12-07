<?php

namespace MiliPay\Gateways\Zarinpal;

use MiliPay\Requester\BasicRequester;
use MiliPay\Response\GatewayResponseHandler;
use MiliPay\ResponseAdapters\ZarinpalAdapter;
use MiliPay\Support\Contract\Gateway;
use MiliPay\Support\Contract\ResourceData;
use MiliPay\Support\Contract\ResponseAdapterHandler;
use MiliPay\Support\Trait\OptionalData;

class ZarinpalManager extends BasicRequester implements ResourceData, Gateway
{
    use OptionalData;
    protected string $driver = 'zarinpal';
    protected string $merchant = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

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

    public function adapter():ZarinpalAdapter
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

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getApiRequest(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->buildRequestData()),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return (array)json_decode($response);
    }

    public function sendRequestVerify()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getApiVerify(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->buildVerifyRequestData()),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

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

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getApiInquiry(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->buildInquiryRequestData(),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return (array)json_decode($response);
    }

    public function buildRequestData(): array
    {
        $requestData = [
            'merchant_id' => $this->getMerchant(),
            'amount' => $this->getAmount(),
            'callback_url' => $this->getCallbackUrl(),
            'description' => $this->getDescription(),
        ];

        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '' && $value != 0;
        });

        return $filteredData;
    }

    public function buildVerifyRequestData(): array
    {
        $requestData = [
            'merchant_id' => $this->getMerchant(),
            'amount' => $this->getAmount(),
            'authority' => $this->getPayId()
        ];
        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '' && $value != 0;
        });

        return $filteredData;
    }

    public function buildInquiryRequestData(): array
    {
        $requestData = [
            'merchant_id' => $this->getMerchant(),
            'authority' => $this->getPayId()
        ];
        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '' && $value != 0;
        });

        return $filteredData;
    }
}
