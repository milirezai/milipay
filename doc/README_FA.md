## مستندات فارسی


##  مستندات
- [اصلی](../README.md)
- [معماری و ساختار داخلی](STRUCTURE.md)


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


وقتی دنبال پکیج واسه اتصال به درگاه های پرداخت کشتم پکیج درست درمونی نبود که همزمان سینتکس لاراولی داشته باشه،کنترل کامل روی پاسخ ها درگاه داشته باشم،کنترل خوبی روی خطا ها داشته باشه و از همه مهم تر یک ساختار  و معماری درست داشته باشه پس منم تصمیم
گرفتم دست به کار بشم و یک  پکیجی بسازم که همه اینا موارد رو رعایت کنه و یه تجربه خوب از استفاده از در گاه ها رو بهم بده 

هدف این پکیج بیشتر اینه که  شما کاری به منطق پرداخت و اتصال به درگاه ها رو نداشته باشید فقط با خیال راحت با چند خط کد عملیات پرداخت خودتون رو انجام بدید و منطق و بقیه کارهای پرداخت با من


تویه این پکیج سعی شده مشکل های رایجی که توی کد های اتصال به درگاه اکثر پروژه ها هست رو حل کنم  اکثر کنترل خوبی روی پاسخ ها نیست اما اینجا قضیه فرق می کنه شما کنترل خط به خط روی پاسخ ها رو دارید بیشتر پکیج ها فقط از یک درگاه به زور پشتیبانی می کنن ولی اینجا شما تا به الان امکان اتصال به دو درگاه معروف ایران رو خیلی راحت دارید و حتما توی آپدیت های آینده درگاه های بیشتری رو ساپورت می کنم تا آزادی بیشتری توی انتخاب درگاه داشته باشید



<h3>چند تا از ویژگی ها:</h3>

- Fluent api کاملا خوانا
- استفاده از پترن های مختلف
- مدیریت کامل روی خطا ها
- کرفتن خروجی به فرمت های مختلف
- ترجعه پاسخ ها
- معماری ماژولار
- اضافه کردن درگاه جدید فقط با یک کلاس
- مدیریت api ها
- فابل تست
- پشتیبانی از در گاه های مختلف
- کانفیک کامل


<h3>روش نصب:</h3>

```php
composer require milirezai/milipay
```

 نسخه php مور نیاز:

 php 8.1 به بعد


نسخه laravel مور نیاز:

laravel 12 به بعد





<h3>ساختار فایل کانفیگ</h3>



تمام کانفیگ درگاه ها توی یک فایل نگه داری شده و برای استفاده از درگاه ابتدا باید فایل رو انتشار بدید

```php
php artisan vendor:publish --tag=milipay-config
```




به طور خود کار پکیج یک درگاه رو برای اتصال انتخاب می کنه این درگاه توی فایل کانفیگ برای مقدار پیش فرض مشخص شده

```php
    "default" => "zarinpal"
```

این پکیج همزمان از چندین در گاه پشتیبانی می کند در این ارایه به ترتیب نام درگاه و، وضعیت فعال بودن درگاه مشخص شده است

```php
   "drivers" => 
   [
      "zibal" => true,
      "zarinpal" => true
   ]
```




یک نمونه کمل از کانفیک یک درگاه پرداخت رو این پایین می بینید


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

فیلد status :

این فیلد وضعیت فعال بودن یک درگاه رو مشخص می کنه

```php
 "status" => true
```


فیلد manager:
 

این بخش یکی از مهم ترین بخش های کانفیگ یک درگاه هستش و مقدار مدیریت کننده یگ درگاه رو نگه داری می کنه و آدرس کلاس مدیریت کننده درگاه مربوط هست


```php
 "manager" => \MiliPay\Gateways\Zibal\ZibalManager::class
 ```


فیلد settings:


این بخش یه جورایی حکم تنظیمات درگاه رو داره که سه تا مقدار رو نگه داری می کنه

merchant: این مقدار رو باید تویه درگاه پرداختی که قصد استفاده از اون رو دارید ثبت نام و دیافت کنید این مقداری که الان پر شده فقط برای تست از کارکرد درگاه است

callbackUrl: این مقدار رو هم توی فایل کانفیگ می تونید مقدار دهی کنید و هم هنگام پرداخت با متد ها مختلفی که براش در نظر گرفته شده ، بعد از پرداخت درگاه کاربر رو به این بخش هدایت می کنه


```php
"settings" => 
[
   "merchant" => "zibal",
   "callbackUrl" => 'app/callback',
]
```


فیلد api:

تمام چرخه پرداخت توسط فیلد های زیر انجام میشه که از هر کدومش برای یک کار استفاده میشه


apiRequest: این مقدار اطاعات رو که شما برای یک پرداخت در نظر گرفتید رو برای درگاه ارسال می کند و یک پاسخ رو بر میگردونه

apiStart: این مقدار کاربر رو به همراه یک شناسه پرداخت به صفحه ای که پرداخت باید انجام بشه هدایت می کنه 

apiVerify : برای برسی پرداخت ها از این مقدار استفاده میشه

apiInquiry: برای استعلام پرداخت ها از این مقدار استفاده میشه

```php
'api' => 
[
   "apiRequest" => "https://gateway.zibal.ir/v1/request",
   "apiStart" => "https://gateway.zibal.ir/start/",
   "apiVerify" => "https://gateway.zibal.ir/v1/verify",
   'apiInquiry' => 'https://gateway.zibal.ir/v1/inquiry'
]
```

فیلد codeMessage :


هر نوع درخواست به سمت درگاه ها شمال یک کد می باشد که از این فیلد برای معنی کردن این کد استفاده میشه

```php
'codeMessage' =>
 [
-1 => 'در انتظار پرداخت'  
 ]
```


<h3>روش استفاده</h3>


<h4>ارسال درخواست پرداخت</h4>


 یک نمونه ساده برای اتصال ، ارسال درخواست و مننتقل شدن به درگاه پرداخت

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

یک نمونه با متد های کاربری

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



کلاس Milipay مدیریت اتصال و انتخاب ما رو به کلاس های اصلی درگاه ها انجام میده

این کلاس متد های متخلفی برای انتخاب درایور درگاه ها در اختیار مار قرار میده


method viaDefaultDriver(): Gateway :

بالا هم توضیح دادام که درون فایل کانفیگ یک درایور پیش فرض ست شده است که در صورتی که ما بخایم از همون درایور استفاده کنیم می تونیم این متد رو صدا بزنیم تا یک نمونه از شی کلاس همون درایور پیش فرض رو به ما بده


method when(\Closure $closure): self :

اگر بخاییم انتخاب درایور پیش فرض با توجه به یک شرط انجام بشه می تونیم از این متد استفاده کنیم این متد که کلوژر به عنوان ارگومان می گیره


method via(string $driver, string $driverDefault = ''): Gateway :

خوب این متد باید دقیفا بعدا از متد ون صدا زده بشه اجرای این متد وابیسته به متد ون و کلوژر هممراه آن است این متد دو ارگومان می گیره اگر نتیجه کلوژر درون متد ون برابر با ترو باشد یعنی درست باشد ارگومان اول این متد به عنوان درایور انتخاب می شود ولی اگر نتیجه کلوژر فالس باشد یعنی نادرست باشد ارگومان دوم این متد به عنوان درایور انتخاب می شود

ارگومان دوم این متد اجباری نیس و اگر ست نشود برای حالت دوم کلوژر یعنی حالت فالس خود پکیج درایور پیش فرض درون فایل کانفیک رو انتخاب می کند



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


ممکنه بخوایید همراه قیمت اطاعات اضافی برای درخواست پرداخت ارسال کنید پایین یک نمونه کامل از متد هایی که برای این کار در نظر گرفته شده و توی اکثر درگاه ها پشتیبانی میشه رو میتونید ببینید



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


شما همچنان می تونید از متد optional() استفاده کنید 

این متد چهار مقدار می گیره

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

<h4>ارسال درخواست تایید</h4>

بعد از پرداخت برای تایید پرداخت می تونید از متد تایید استفاده کنید برای در خواست  نیاز به شناسه پرداخت دارید 
 
```php
    $pay = $milipay
        ->viaDefaultDriver()
        ->payId(424234234234)
        ->verify();
     dd($pay->response()->toArray());
```

در بعضی از درگاه ها مثل زرینپال برای درخواست تایید نیاز به مقدار پول پرداخت شده هم وجود دارد و باید ارسال بشه

```php
    $pay = $milipay
        ->viaDefaultDriver()
         ->amount(150000)
        ->payId(424234234234)
        ->verify();
     dd($pay->response()->toArray());
```

<h4>ارسال درخواست استعلام</h4>

برای استعلام پرداخت در صورتی که نیاز داشتید می تونید به صورت پایین رفتار کنید


```php
    $pay = $milipay
        ->viaDefaultDriver()
        ->payId(424234234234)
        ->inquiry();
     dd($pay->response()->toArray());
```

<h4>مدیریت پاسخ در خواست ها </h4>
 

برای مدیریت پایخ های متد ها و روش های مختلفی وجود دارد، می توان پاسخ ها رو به فرمت های مختلف در یافت کنید
 

متد ریسپانس یک نمونه شی از کلاسی که مدیریت رسیدگی به پاسخ ها رو دارد رو بر می گردونه و شما میتونید متد های دلخواهی رو از روی این شی صدا بزنید و پاسخ ها رو به صورت دلخواه دریافت و ذخیره کنید



method toJson():json


متد تو جیسون پاسخ رو به صورت جیسون ارسال می کند 

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


و متد تو ارایه پاسخ رو به صورت آرایه ارسال می کند 


```php 
$pay->response()->toArray()
```


method isSuccessful():boll


این متد بررسی می‌کند که آیا پیام دریافتی از درگاه پرداخت برابر با موفقیت‌آمیز بودن است یا خیر. در صورت صحیح بودن، مقدار True را برمی‌گرداند.


```php 
$pay->response()->isSuccessful()
```


method isFailed(): bool


این متد سناریوی مخالف متد isSuccessful() را بررسی می‌کند.


```php 
$pay->response()->isFailed()
```


method getMessage():string


اگر می خوایید پبام ارسال شده از سمت درگاه رو مشاهده کنید


```php 
$pay->response()->getMessage()
```


method getPayId(): int|string


می‌توان گفت متد getPayId() مهم‌ترین پاسخی است که از درگاه می‌آید. این متد بسته به درگاه‌های مختلف می‌تواند انواع مختلفی داشته باشد. این قسمت برای تأیید و استعلام‌های پرداخت مورد نیاز است، بنابراین حتماً آن را ذخیره کنید تا بعداً برای سایر قسمت‌ها استفاده شود.


```php 
$pay->response()->getPayId()
```


method getCodeMessage():string

با هر پاسخ به درگاه، کدی تولید و برای ما ارسال می‌شود که نشان‌دهنده وضعیت و نتیجه است، با استفاده از این روش می توان به معنای این کد پی برد.


```php 
$pay->response()->getCodeMessage()
```


method whenSuccess(Closure $success, Closure $failed) : 

 ممکن است بخواهید بسته به پاسخی که از سمت درگاه پرداخت امده است یک عملیات انجام دهید این متد این کارو برای شما انجام مییده این متد برسی میکنه که پاسخی که از سمت در گاه اومده مساوی درست است یا خیر  این متد رو ارگومان میگیره که هر دو از نوع کلوژر هستند این متد برسی میکنه اگر جواب دریافت شده از درگاه مساوی ترو یعنی درست باشد کلوژر اول رو اجرا میکنه واگر مساوی فالس یعنی اشتباه باشد کلوژر دوم رو اجرا می کنه هر کدوم از این کلوژر ها به شی ریسپانس دسترسی دارن و می تونید از ریسپانس ها هم داخل کلوژر ها استفاده کنید


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

این متد هم دقیا کار متد بالا رو انجام میده ولی برعکس یعنی حالت فالس یعنی اشتباه پاسخ درگاه رو برسی میکنه


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


<h4>api ها:</h4>

شما می توانید ای پی ای ها را جدا از فایل کانفیک و پیش فرض، داخل کد و هنگام انجام عملیات پرداخت نیز مقدار دهی کنید برای این کار متد های مختلفی رو در نطر گرفتم

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


با می توانید از روش زیر استفاده کنید
 
ترتیب دادان ارگومان ها در این متد مهم نیست و پاس دادان همه ارگومان ها ضروری نیست و شما می توانید برای مقدار دهی یک تا چند مورد از این متد استفاده کنید

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

شما هم چنان می توانید مرچنت ای دی خود را نیز جدا از فایل کانفیک و با متد مود نظر مقدار دهی کنید

```php
     $pay = $milipay
        ->viaDefaultDriver()
        ->merchant('zibal')
        ->amount(150000)
        ->request();
```


 <h3>Facades</h3>
 
برای راحتی کار می توانید از Facades Milipay استفاده کنید 


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
