<?php

namespace MiliPay\ErrorHandler;

use MiliPay\Support\Contract\ErrorHandler;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentErrorHandler implements ErrorHandler
{
    protected string $error = '';
    protected bool $log = false;

    public function set(string $error): self
    {
        $this->error = $error;
        return $this;
    }

    public function log(): self
    {
        $this->log = true;
        return $this;
    }

    public function get(): string
    {
        return $this->error;
    }

    public function has(): bool
    {
        return $this->error != '' ? true : false;
    }

    public function toException(): self
    {
        throw new Exception($this->get());
        return $this;
    }

    public function error(): self
    {
        if ($this->log){
            Log::error($this->get());
            return $this;
        }
        $this->set('Not allowed to use the logging system.')->toException();
    }

    public function warning(): self
    {
        if ($this->log){
            Log::warning($this->get());
            return $this;
        }
        $this->set('Not allowed to use the logging system.')->toException();
    }

    public function info(): self
    {
        if ($this->log){
            Log::info($this->get());
            return $this;
        }
        $this->set('Not allowed to use the logging system.')->toException();
    }
}
