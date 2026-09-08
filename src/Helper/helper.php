<?php


use Illuminate\Support\Facades\Log;

if (! function_exists('pay_config')) {
    function pay_config(string $key, mixed $default = null): mixed
    {
        $publishedConfig = config_path('pay.php');

        if (file_exists($publishedConfig)) {
            return config("pay.{$key}", $default);
        }

        Log::warning('pay config not published',[]);
        $packageConfig = require __DIR__ . '/../../pay.php';

        return data_get($packageConfig, $key, $default);
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
        $file = require __DIR__.'/../../translateResponseCode.php';
        $message = $file[$driver]['codeMessage'][$code];
        if ($message)
            return $message;
        else
            return null;
    }
}
