<?php

use Mili\Milipay\Exceptions\MilipayException;

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

if (!function_exists('translate_response_code')){
    function translate_response_code(int $code, string $driver): string|null
    {
        $file = __DIR__.'/../../translateResponseCode.php';
        $translateCode = file_get_contents($file);
        $message = $translateCode[$driver]['codeMessage'][$code];
        if ($message)
            return $message;
        else
            return null;
    }
}
