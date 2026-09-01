<?php

return
    [

        'every' => 15,

        'storages' =>
            [

                'default' => 'local',
                'disks' =>
                    [
                        'local' =>
                            [
                                'root' => __DIR__ . '/../probe.log'
                            ],
                        'mysql' =>
                            [
                                'root' => 'fast_driver',
                            ],
                        'redis' =>
                            [
                                'root' => 'fast_driver'
                            ]
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

            ],
    ];
