<?php

use MiliPay\Config\ConfigGateway;
use MiliPay\ErrorHandler\PaymentErrorHandler;

// instanse fo class ConfigGateway
if (!function_exists('gateConfig')){
    function gateConfig(): ConfigGateway
    {
        return app()->make(ConfigGateway::class);
    }
}
// instanse fo class PaymentErrorHandler
if (!function_exists('errorHandler')){
    function errorHandler(): PaymentErrorHandler
    {
        return app()->make(PaymentErrorHandler::class);
    }
}
