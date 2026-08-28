<?php

namespace Mili\Milipay\Response;

use Mili\Milipay\Contracts\ResponseHandler;
use Closure;
use Illuminate\Http\RedirectResponse;

class PayResult implements ResponseHandler
{
    private ResponseHandler $response;

    public function init(mixed $response): static
    {
        $this->response = $response;
        return $this;
    }

    public function responseTime(): float
    {
        return $this->response->responseTime();
    }
    public function toJson()
    {
        return $this->response->toJson();
    }

    public function toArray()
    {
        return $this->response->toArray();
    }

    public function isSuccessful(): bool
    {
        return $this->response->isSuccessful();
    }

    public function isFailed(): bool
    {
        return $this->response->isFailed();
    }

    public function getMessage(): string
    {
        return $this->response->getMessage();
    }

    public function getPayId(): int|string
    {
        return $this->response->getPayId();
    }

    public function getCodeMessage(): string|null
    {
        return $this->response->getCodeMessage();
    }
    public function whenSuccess(Closure $success, Closure $failed)
    {
        if ($this->isSuccessful()){
            $response = call_user_func($success,$this);
            if ($response instanceof RedirectResponse){
                return $response;
            }
        }
        else{
            $response = call_user_func($failed,$this);
            if ($response instanceof RedirectResponse){
                return $response;
            }
        }
    }

    public function whenFailed(Closure $failed, Closure $success)
    {
        if ($this->isFailed()){
            $response =  call_user_func($failed,$this);
            if ($response instanceof RedirectResponse){
                return $response;
            }
        }
        else{
            $response = call_user_func($success,$this);
            if ($response instanceof RedirectResponse){
                return $response;
            }
        }
    }

}
