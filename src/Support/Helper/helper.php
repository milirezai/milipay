<?php
use Milipay\Exceptions\MilipayException;

if (!function_exists('pay_config')){
    function pay_config(string $key)
    {
        if (!file_exists(config_path('pay.php')))
            throw new MilipayException('config not published',404);
        return config('pay.'.$key);
    }
}


if (!function_exists('response_time')){
    function response_time(float $start, float $end)
    {
        return round(($end - $start) * 1000,2);
    }
}
