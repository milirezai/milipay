<?php

return [

    "default" => "zibal",

    "drivers" => [
        "zibal" => true
    ],


    "gateways" => [

        "zibal" => [

            "status" => true,
            "manager" => \MiliPay\Gateways\Zibal\ZibalManager::class,

            "settings" => [
                "merchant" => "zibal",
                "callbackUrl" => 'app/callback',
                "default_description" => 'Request payment in Zibal'
            ],

            'api' => [
                "apiRequest" => "https://gateway.zibal.ir/v1/request",
                "apiStart" => "https://gateway.zibal.ir/start/",
                "apiVerify" => "https://gateway.zibal.ir/v1/verify",
                'apiInquiry' => 'https://gateway.zibal.ir/v1/inquiry'
            ],
            "responseKey" => [
                "trackId" => "trackId", // for response method trackId
                "result" => "result:100", // for response method codeMessage
                "message" => "message:success" // for response method success
            ],

            'codeMessage' => [
                -1 => 'در انتظار پرداخت',
                -2 => 'خطای داخلی',
                1 => 'پرداخت شده - تاییدشده',
                2 => 'پرداخت شده - تاییدنشده',
                3 => 'لغوشده توسط کاربر',
                4 => 'شماره کارت نامعتبر می‌باشد',
                5 => 'موجودی حساب کافی نمی‌باشد',
                6 => 'رمز واردشده اشتباه می‌باشد.',
                7 => 'تعداد درخواست‌ها بیش از حد مجاز می‌باشد',
                8 => 'تعداد پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد',
                9 => 'مبلغ پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد',
                10 => 'صادرکننده‌ی کارت نامعتبر می‌باشد',
                11 => 'خطای سوییچ',
                12 => 'کارت قابل دسترسی نمی‌باشد',
                15 => 'تراکنش استرداد شده',
                16 => 'تراکنش در حال استرداد',
                18 => 'تراکنش ریورس شده',
                21 => 'پذیرنده نامعتبر است',
                100 => 'با موفقیت تایید شد',
                102 => 'merchantیافت نشد.',
                103 => 'merchantغیرفعال',
                104 => 'merchantنامعتبر',
                105 => 'بایستی  بزرگتر از 1,000 ریال باشدamount',
                201 => 'قبلا تایید شده',
                202 => 'سفارش پرداخت نشده - ناموفق بوده',
                203 => 'trackIdنامعتبر می‌باشد.',
            ]

        ],



    ]



];

