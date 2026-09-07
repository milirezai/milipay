<?php

return
    [

        "defaultDriver" => "zibal",

        "drivers" =>
            [
                "zibal" =>
                    [
                        "status" => true,
                        "manager" => \Mili\Milipay\Drivers\Zibal\Zibal::class,
                        "adapter" => \Mili\Milipay\Drivers\Zibal\Response::class,
                        "payloadBuilder" => \Mili\Milipay\Drivers\Zibal\PayloadBuilder::class,
                        "merchant" => "zibal",
                        "timeout" => 8,
                        "retry" => 2,
                        'api' =>
                            [
                                "request" => "https://gateway.zibal.ir/v1/request",
                                "start" => "https://gateway.zibal.ir/start/",
                                "verify" => "https://gateway.zibal.ir/v1/verify",
                                'inquiry' => 'https://gateway.zibal.ir/v1/inquiry',
                                "callbackUrl" => 'app/callback'
                            ]
                    ],

                'zarinpal' =>
                    [
                        'status' => true,
                        'manager' => \Mili\Milipay\Drivers\Zarinpal\Zarinpal::class,
                        'adapter' => \Mili\Milipay\Drivers\Zarinpal\Response::class,
                        'payloadBuilder' => \Mili\Milipay\Drivers\Zarinpal\PayloadBuilder::class,
                        'merchant' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                        'timeout' => 8,
                        'retry' => 2,
                        'api' =>
                            [
                                "request" => "https://sandbox.zarinpal.com/pg/v4/payment/request.json",
                                "start" => "https://sandbox.zarinpal.com/pg/StartPay/",
                                "verify" => "https://sandbox.zarinpal.com/pg/v4/payment/verify.json",
                                'inquiry' => 'https://sandbox.zarinpal.com/pg/v4/payment/inquiry.json',
                                "callbackUrl" => 'app/callback'
                            ]
                    ]

            ],

        'fastDriver' =>
            [

                'enabled' => true,
                'every' => 15,
                'numberOfProbePerDriver' => 4,
                'storages' =>
                    [
                        'default' => 'local',
                        'disks' =>
                            [
                                'local' =>
                                    [
                                        'root' => storage_path('logs/probe.log')
                                    ],
                            ],
                    ],
                'sandbox' =>
                    [

                        "drivers" =>
                            [
                                "zibal" =>
                                    [
                                        "merchant" => 'zibal',
                                        "amount" => rand(1000000,9000000),
                                        "description" => "ping driver zibal",
                                        'timeout' => 7,
                                        'retry' => 2,
                                        'api' =>
                                            [
                                                "request" => "https://gateway.zibal.ir/v1/request",
                                                "callbackUrl" => 'https://github.com/milirezai/milipay'
                                            ]
                                    ],
                                'zarinpal' =>
                                    [
                                        'merchant' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                                        "amount" => rand(1000000,9000000),
                                        "description" => "ping driver zarinpal",
                                        'timeout' => 7,
                                        'retry' => 2,
                                        'api' =>
                                            [
                                                "request" => "https://sandbox.zarinpal.com/pg/v4/payment/request.json",
                                                "callbackUrl" => 'https://github.com/milirezai/milipay'
                                            ]
                                    ]

                            ]

                    ]

            ]

    ];
