## milipay




## Documentation

- [Architecture and internal structure](doc/STRUCTURE.md)
- [Persian Documentation](doc/README_FA.md)



```php
milipay/
├─ src/
│  ├─ PaymentServiceProvider::class
│  ├─ Config/
│  │  ├─ ConfigGateway::class
│  ├─ ErrorHandler/
│  │  ├─ PaymentErrorHandler::class
│  ├─ Facade/
│  │  ├─ MiliPay::class
│  │  ├─ MiliPayConfig::class
│  │  ├─ MiliPayError::class
│  ├─ Gateways/
│  │     ├─ Zarinpal/
│  │      ├─ ZarinpalManager::class
│  │     └─ Zibal/
│  │      ├─ ZibalManager::class
│  ├─ Manager/
│  │  ├─ MiliPay::class
│  ├─ Requester/
│  │  ├─ BasicRequester::class
│  ├─ Response/
│  │  ├─ GatewayResponseHandler::class
│  ├─ ResponseAdapters/
│  │     ├─ ZarinpalAdapter::class
│  │     ├─ ZibalAdapter::class
│  └─ Support/
│   ├─ Contract/
│  │     ├─ ErrorHandler::class
│  │     ├─ Gateway::class
│  │     ├─ GatewayManager::class
│  │     ├─ RequestHandler::class
│  │     ├─ ResourceData::class
│  │     ├─ ResponseAdapterHandler::class
│  │     ├─ ResponseHandler::class
│   ├─ Helper/
│  │     ├─ helper.php
│   ├─ Trait/
│  │     ├─ ConnectionMethod::class
│  │     ├─ OptionalData::class
│  │     ├─ Serviceable::class
├─ doc/
│  └─ README_FA.md
│  └─ STRUCTURE.md
├─ pay.php
├─ composer.json
└─ README.md
```



When I was looking for a package to connect to payment gateways, there was no right package that would simultaneously have Laravel syntax, give me full control over the gateway responses, have good control over errors, and most importantly, have a proper structure and architecture. So I decided to get to work and create a package that would meet all of these requirements and give me a good experience using the gateways


The purpose of this package is that you don't have to deal with payment logic and connection to the gateways, just safely perform your payment operations with a few lines of code, and leave the logic and other payment tasks to me



In this package, I have tried to solve the common problems that are found in the port connection codes of most projects. Most of them do not have good control over the responses, but here the situation is different. You have line-by-line control over the responses. Most packages only support one port by force, but here you have the possibility to connect to two famous Iranian ports very easily so far. And I will definitely support more ports in future updates so that you have more freedom in choosing the port



Some of the features:

- Fluent api is completely readable
- Using different patterns
- Complete error management
- Convert output to different formats
- Translation of answers
- Modular architecture
- Adding a new gateway with just one class
- API management
- Fable test
- Support for various gateways
- Complete configu








<h3>Installation method:</h3>


```php
composer require milirezai/milipay
```


PHP version required:

PHP 8.1 or later


Laravel version required:

laravel 12 and later


<h3>Config file structure</h3>


All port configurations are stored in a file and to use the port, you must first publish the file.


```php
php artisan vendor:publish --tag=milipay-config
```


The package task automatically selects a port to connect to. This port is specified in the twi config file for the default value.

```php
    "default" => "zarinpal"
```


This package also supports this method, in which case the port name and port activation status are specified respectively.


```php
   "drivers" => 
   [
      "zibal" => true,
      "zarinpal" => true
   ]
```



You can see a complete example of a payment gateway configuration below.


```php
// start config zibal
        "zibal" => [

            "status" => true,
            "manager" => \MiliPay\Gateways\Zibal\ZibalManager::class,

            "settings" => [
                "merchant" => "zibal",
                "callbackUrl" => 'app/callback',
            ],

            'api' => [
                "apiRequest" => "https://gateway.zibal.ir/v1/request",
                "apiStart" => "https://gateway.zibal.ir/start/",
                "apiVerify" => "https://gateway.zibal.ir/v1/verify",
                'apiInquiry' => 'https://gateway.zibal.ir/v1/inquiry'
            ],
            'codeMessage' => [
                -1 => 'در انتظار پرداخت',
            ]

        ],
        // end config ibal

```


Field status:

This field specifies the active status of a port.


```php
 "status" => true
```



field manager:


This section is one of the most important sections of a port configuration and stores the value of a port manager and the address of the corresponding port manager class.


```php
 "manager" => \MiliPay\Gateways\Zibal\ZibalManager::class
 ```


Settings field:

This section is kind of like a gateway configuration that stores three values.


merchant: You must enter this amount in the payment gateway you intend to use. This amount is only for testing the functionality of the gateway.


callbackUrl: You can set this value in the configuration file, and when paying with the various methods provided for it, the portal will redirect the user to this section after payment.



```php
"settings" => 
[
   "merchant" => "zibal",
   "callbackUrl" => 'app/callback',
]
```


api field:


The entire payment cycle is handled by the following fields, each of which is used for a specific task.

apiRequest: This sends the amount of information you have specified for a payment to the portal and returns a response.


apiStart: This value redirects the user to the page where the payment should be made, along with a payment ID.

apiVerify: This value is used to verify payments.

apiInquiry: This value is used to inquire about payments.

```php
'api' => 
[
   "apiRequest" => "https://gateway.zibal.ir/v1/request",
   "apiStart" => "https://gateway.zibal.ir/start/",
   "apiVerify" => "https://gateway.zibal.ir/v1/verify",
   'apiInquiry' => 'https://gateway.zibal.ir/v1/inquiry'
]
```

codeMessage field:

Each type of request to the northbound ports is a code, and this field is used to interpret this code.

```php
'codeMessage' =>
 [
-1 => 'در انتظار پرداخت'  
 ]
```


<h3>Method of use</h3>


A simple example for connecting, sending a request, and being redirected to a payment gateway



```php

use MiliPay\Manager\MiliPay;


public function (Milipay $milipay)
    {
          $pay = $milipay
        ->gate()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
        return $pay->pay();
    }

```

The Milipay class handles our connection and selection to the main gateway classes.


This class includes the gate() and with() methods.


gate() method:

Automatically selects the default port written in the config file and uses that port for payment and other processes.

method with():

If you want to change the default port and don't want to make any changes to the configuration file, you can use this method and give it the port name, but the port must be one of our supported ports for the program to work properly.


```php
    $pay = $milipay
        ->with('zibal')
        ->gate()
```


You may want to send additional information along with the price to request payment. You can see a complete example of the methods that are intended for this task and supported by most portals.


```php
    $pay = $milipay
        ->gate()
        ->amount(150000)
        ->orderId(1)
        ->description('pay with package milipay')
        ->mobile('09124855440')
        ->nationalCode(423423423)
        ->email('milipay@gmail.com')
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
      
     return $pay->pay();
```


You can still use the optional() method.

This method takes four values.

```php
    $pay = $milipay
        ->gate()
        ->amount(150000)
        ->optional(
        orderId: 1,
        description: 'pay with package milipay',
        mobile: '09124855440',
        nationalCode: 423423423
        )
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
```


<h4>Submit a confirmation request</h4>

After payment, you can use the verification method to receive your ID card.



```php
    $pay = $milipay
        ->gate()
        ->payId(424234234234)
        ->verify();
     dd($pay->response()->toArray());
```

In the case of portals like Zarinpal, there is also a requirement for a certain amount of money to be paid and it must be sent.


```php
    $pay = $milipay
        ->gate()
         ->amount(150000)
        ->payId(424234234234)
        ->verify();
     dd($pay->response()->toArray());
```


<h4>Send inquiry request</h4>


To inquire about payment, if you need to, you can proceed as follows:



```php
    $pay = $milipay
        ->gate()
        ->payId(424234234234)
        ->inquiry();
     dd($pay->response()->toArray());
```

<h4>Request response management</h4>


There are various methods and approaches to managing databases, and you can find answers in different formats.


The response method returns an instance of the class that manages a response to the responses, and you can call any methods on this object and receive and store the responses as desired.


method toJson():json


Your json method sends the response as json.

```php
    $pay = $milipay
        ->gate()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
      Payment::create($pay->response()->toJson())
     return $pay->pay();
```

method toArray():array


And your method will send the response as an array.

```php 
$pay->response()->toArray()
```


method isSuccessful():boll


This method checks whether the message received from the payment gateway is successful or not. If so, it returns True.

```php 
$pay->response()->isSuccessful()
```


method isFailed(): bool


This method checks the opposite scenario of the isSuccessful() method.

```php 
$pay->response()->isFailed()
```


method getMessage():string


If you want to see the message sent from the portal

```php 
$pay->response()->getMessage()
```


method getPayId(): int|string


The getPayId() method is arguably the most important response that comes from the portal. This method can have different types depending on the portal. This field is required for verification and payment queries, so be sure to save it for later use in other fields.

```php 
$pay->response()->getPayId()
```


method getCodeMessage():string

With each response to the portal, a code is generated and sent to us that indicates the status and result. Using this method, we can understand the meaning of this code.

```php 
$pay->response()->getCodeMessage()
```





<h4>apis:</h4>

You can set APIs separately from the config and default files, inside the code and when performing the payment operation. I considered various methods for this.



```php 
    $pay = $milipay
        ->gate()
        ->apiRequest("https://gateway.zibal.ir/v1/request")
        ->apiStart("https://gateway.zibal.ir/start/")
        ->callbackUrl('http://localhost:8000/callback')
         ->amount(150000)
        ->request();
```


```php
    $pay = $milipay
        ->gate()
        ->apiVerify("https://gateway.zibal.ir/v1/verify")
        ->payId(424234234234)
        ->verify();
```

```php
    $pay = $milipay
        ->gate()
        ->apiInquiry("https://gateway.zibal.ir/v1/inquiry")
        ->payId(424234234234)
        ->inquiry();
```


You can use the following method.



The order of the arguments in this method is not important and it is not necessary to pass all the arguments and you can use this method to assign values ​​to one or more items.


```php 
    $pay = $milipay
        ->gate()
        ->apis(
         apiRequest: "https://gateway.zibal.ir/v1/request",
            apiStart: "https://gateway.zibal.ir/start/",
            apiVerify: "https://gateway.zibal.ir/v1/verify",
            apiInquiry: "https://gateway.zibal.ir/v1/inquiry",
            callback: "http://localhost:8000/"
        )
        ->amount(150000)
        ->request();
```

You can also set your merchant ID separately from the config file using the comment mode method.


```php
     $pay = $milipay
        ->gate()
        ->merchant('zibal')
        ->amount(150000)
        ->request();
```

<h3>Facades</h3>

For convenience, you can use Milipay Facade

```php

use MiliPay\Facade\MiliPay;


public function ()
    {
     $pay = MiliPay::gate()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
        return $pay->pay();
    }

```


```php
milirezaix@gmail.com
```
