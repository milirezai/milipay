<?php

namespace MiliPay\Support\Contract;

interface ErrorHandler
{
    public function set(string $error):self;
    public function log():self;
    public function get():string;
    public function has():bool;
    public function toException():self;
    public function error():self;
    public function warning():self;
    public function info():self;
}
