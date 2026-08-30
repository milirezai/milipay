<?php

namespace Mili\Milipay\Requester;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Mili\Milipay\Exceptions\MilipayException;

class Requester
{
    public function post(int $timeout, int $retry, string $api, mixed $data): array
    {
        try {
            $start = microtime(true);
            $response = Http::timeout($timeout)
                ->retry($retry,150)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->asJson()->post($api,$data);

            $end = microtime(true);

            return $this->resolveResponse(start_time: $start, end_time: $end, response: $response);
        }catch (RequestException $e){
            throw new MilipayException($e->getMessage(),$e->getCode());
        }
    }
    private function resolveResponse(int $start_time, int $end_time, mixed $response): array
    {
        $response_time_ms = response_time($start_time,$end_time);
        $responseDecode = (array) json_decode($response->body());
        $finalResponse = Arr::add($responseDecode,'response_time_ms',$response_time_ms);
        return $finalResponse;
    }
}
