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



<h3>Payment request cycle</h3>


It all starts when you call the MilliPay class. It doesn't matter how you call it. Then this class gives you a few different methods to use, which I explained in its own time and place, and there's no need for more here. Finally, you access one of the drivers, the same class that manages a payment gateway, through the MilliPay class. Now you need to specify your goal, what operation you want to perform on the gateway: send a request for payment, confirm a payment, or inquire about a payment. After you have specified your goal, you need to know what information you need to send for the goal. For confirmation requests, gateways have different behaviors. Some only need the payment ID for confirmation, while some ask you for both the payment ID and the amount paid. You can do two things: send both the payment ID and the amount for all gateways, or you can check which gateways require an amount for confirmation. For payment inquiries, all gateways only need the payment ID, and for payment, The main goal and operation that you can do is the main data that you need to send is the amount. Some portals also require explanations, so I think you should send a short explanation for all portals, and the rest of the data is not necessary for payment, and sending them depends on your choice. Okay, now we have both defined our goal and we know what data we need to send for each attribute. Then, depending on the operation, we enter one of the request methods of the handler. There, only the request is sent. The data template is created in another method. These request handlers send our request to the portal and receive a response. For each of the operation goals, a method is provided in this method. We store the request response handler in the response property and return the class object. Now, in the continuation of this chain of methods, we can consider and use two paths: either we want to go to the portal and complete the operation, or we want to save the response, or something else. To go to the portal, we need to use the method Calling the P from the object will redirect us to the portal. If we want to receive the response, we call the Response method from the object. This method sends an instance of the main Response handler class, which is very professionally written and has many methods to use.


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
        ->viaDefaultDriver()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
        return $pay->pay();
    }

```



Example with functional methods

```php

$pay = MiliPay::when(function (){
    return $type == 1 ? true : false;
})->via('zibal','zarinpal')
    ->amount(24234)
    ->request();
$pay->response()
    ->whenSuccess(function ($response) use ($pay){
        Payment::create($response->toJson());
        return $pay->pay();
    },function ($response){
        Log::error($response->toArray());
    });
```


The Milipay class manages our connection and selection to the main gateway classes.


This class provides the snake with default methods for selecting port drivers.


method viaDefaultDriver(): Gateway :


I explained above that a default driver is set in the configuration file, so if we want to use the same driver, we can call this method to give us an instance of the class object of the same default driver.


method when(\Closure $closure): self :


If we want the default driver to be selected based on a condition, we can use this method, which takes a closure as an argument.


method via(string $driver, string $driverDefault = ''): Gateway :


Well, this method should be called just after the method. The execution of this method depends on the method and the closure that accompanies it. This method takes two arguments. If the result of the closure inside the method is true, i.e., true, the first argument of this method is selected as the driver. But if the result of the closure is false, i.e., incorrect, the second argument of this method is selected as the driver.


The second argument of this method is not mandatory, and if it is not, for the second state, i.e., false state, Closure itself configures the default driver package in the file.



```php
MiliPay::when(function (){
    return true;
})->via('zibal')
```

```php
MiliPay::when(function (){
    return false;
})->via('zibal','zarinpal')
```



You may want to send additional information along with the price to request payment. You can see a complete example of the methods that are intended for this task and supported by most portals.


```php
    $pay = $milipay
        ->viaDefaultDriver()
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
        ->viaDefaultDriver()
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
        ->viaDefaultDriver()
        ->payId(424234234234)
        ->verify();
     dd($pay->response()->toArray());
```

In the case of portals like Zarinpal, there is also a requirement for a certain amount of money to be paid and it must be sent.


```php
    $pay = $milipay
        ->viaDefaultDriver()
         ->amount(150000)
        ->payId(424234234234)
        ->verify();
     dd($pay->response()->toArray());
```


<h4>Send inquiry request</h4>


To inquire about payment, if you need to, you can proceed as follows:



```php
    $pay = $milipay
        ->viaDefaultDriver()
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
        ->viaDefaultDriver()
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




method whenSuccess(Closure $success, Closure $failed) :

You may want to perform an operation depending on the response received from the payment gateway. This method does this for you. This method checks whether the response received from the gateway is equal to true or not. This method takes an argument that both are closures. This method checks if the response received from the gateway is equal to true, i.e. true, it executes the first closure, and if it is equal to false, i.e. wrong, it executes the second closure. Each of these closures has access to the response object and you can also use responses inside closures


```php 
MiliPay::viaDefaultDriver()
    ->amount(24234)
    ->request()
    ->response()
    ->whenSuccess(function ($response){
        // run if message = success
    },function ($response){
        // run if message != success
    });
```


method whenFailed(Closure $failed, Closure $success) :

This method does exactly the same thing as the above method, but in reverse, meaning it checks for a false state, meaning an error in the gateway response

```php 
MiliPay::viaDefaultDriver()
    ->amount(24234)
    ->request()
    ->response()
    ->whenFailed(function ($response){
        // run if message != success
    },function ($response){
        // run if message = success
    });
```




<h4>apis:</h4>

You can set APIs separately from the config and default files, inside the code and when performing the payment operation. I considered various methods for this.



```php 
    $pay = $milipay
        ->viaDefaultDriver()
        ->apiRequest("https://gateway.zibal.ir/v1/request")
        ->apiStart("https://gateway.zibal.ir/start/")
        ->callbackUrl('http://localhost:8000/callback')
         ->amount(150000)
        ->request();
```


```php
    $pay = $milipay
        ->viaDefaultDriver()
        ->apiVerify("https://gateway.zibal.ir/v1/verify")
        ->payId(424234234234)
        ->verify();
```

```php
    $pay = $milipay
        ->viaDefaultDriver()
        ->apiInquiry("https://gateway.zibal.ir/v1/inquiry")
        ->payId(424234234234)
        ->inquiry();
```


You can use the following method.



The order of the arguments in this method is not important and it is not necessary to pass all the arguments and you can use this method to assign values ​​to one or more items.


```php 
    $pay = $milipay
        ->viaDefaultDriver()
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
        ->viaDefaultDriver()
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
     $pay = MiliPay::viaDefaultDriver()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
        return $pay->pay();
    }

```


```php
milirezaix@gmail.com
```
