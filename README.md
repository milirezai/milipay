## milipay



Installation:

```php
composer require milirezai/milipay
```



## Documentation

- [Architecture and internal structure](doc/STRUCTURE.md)
- [English Documentation](doc/README_EN.md)
- [Persian Documentation](doc/README_FA.md)

<p>useing:</p>

publish config

To use the package, first extract the configuration file with the following command:
Publish Config:

```php
php artisan vendor:publish --tag=milipay-config
```



start use

Note: For each request, you need to specify a callback URL to be redirected there after payment.
You can do this in two ways:
First = In the config file for the specified gateway and set a default value for the callback URL argument, or you can use the callbackUrl(string $callbackUrl) or apis(callback: $callbackUrl) methods.
simple example

```php
 public function (Milipay $milipay)
    {
          $pay = $milipay
        ->gate()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
    if ($pay->response()->isSuccessful())
    {
        return $pay->pay();
    }else{
        dd($pay->response()->toArray());
    }
    }
```


You can send more information to the payment gateway.


```php
 public function (Milipay $milipay)
    {
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
    }
```


More comprehensive methods can be used.

The order of the arguments in this optional() method does not matter.
```php
 public function (Milipay $milipay)
    {
          $pay = $milipay
        ->gate()
        ->amount(150000)
        ->optional(
            orderId: 1, mobile: '09124855440',
            natinalCode: 423423423, description: 'pay with package milipay'
        )
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
    }
```

Sending one argument is enough for this method optional() to work properly, but use this method when you intend to send more information, otherwise use individual methods.

Redirect the user to the payment gateway


You can use the pay() method for this.
```php
 public function (Milipay $milipay)
    {
          $pay = $milipay
        ->gate()
        ->amount(150000)
        ->callbackUrl('http://localhost:8000/callback')
        ->request();
        return $pay->pay()
    }
```


## response managment

The response method returns an instance of the response handler from which you can call different methods depending on your needs and desires.




You can get the answers from the right side of the page in two different formats.

method toJson():json

```php 
$pay->response()->toJson()
```
method toArray():array

```php 
$pay->response()->toArray()
```


method isSuccessful():boll

This method checks whether the message received from the payment gateway is equal to success or not. If it is true, it returns the value True.
```php 
$pay->response()->isSuccessful()
```

method isFailed(): bool
This method checks the opposite scenario of the isSuccessful() method.
```php 
$pay->response()->isFailed()
```

method getMessage():string
If you can access the message from the gateway side
```php 
$pay->response()->getMessage()
```

method getPayId(): int|string


It can be said that the getPayId() method is the most important response that comes from the gateway. This method can have different types depending on different gateways. This section is needed for verification and payment inquiries, so be sure to save it so that it can be used later for other sections.
```php 
$pay->response()->getPayId()
```

<h3>method getCodeMessage():string</h3>

With each response to the gateway, a code is generated and sent to us, indicating the status and result, if the meaning of this code can be understood using this method.

```php 
$pay->response()->getCodeMessage()
```