
<h3 align="center">
Milipay
</h3>

<p align="center">
    <strong>Payment Package for Laravel</strong>
</p>

<p  align="center">

[![Latest Stable Version](https://img.shields.io/packagist/v/milirezai/milipay.svg?style=flat-square)](https://packagist.org/packages/milirezai/milipay)
[![Total Downloads](https://img.shields.io/packagist/dt/milirezai/milipay.svg?style=flat-square)](https://packagist.org/packages/milirezai/milipay)
[![PHP Version](https://img.shields.io/packagist/php-v/milirezai/milipay.svg?style=flat-square)](https://packagist.org/packages/milirezai/milipay)
[![Laravel](https://img.shields.io/badge/Laravel-12.x|13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
![GitHub Stars](https://img.shields.io/github/stars/milirezai/milipay?style=flat&logo=github)
![Contributors](https://img.shields.io/github/contributors/milirezai/milipay?style=flat)
![GitHub Forks](https://img.shields.io/github/forks/milirezai/milipay?style=flat&logo=github)
![GitHub Issues](https://img.shields.io/github/issues/milirezai/milipay?style=flat&logo=github)

</p>


وقتی دنبال پکیج واسه اتصال به درگاه های پرداخت گشتم پکیج درست درمونی نبود که همزمان سینتکس لاراولی داشته باشه،کنترل کامل روی پاسخ ها درگاه داشته باشم،کنترل خوبی روی خطا ها داشته باشه و از همه مهم تر یک ساختار  و معماری درست داشته باشه پس منم تصمیم
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
- اضافه کردن درگاه جدید بدون تغییر در هسته
- مدیریت api ها
- فابل تست
- پشتیبانی از در گاه های مختلف
- کانفیک کامل
- امکان تنظیم timeout  و  retry برای هر درگاه و هر درخواست
- اعتبار سنجی کامل ورودی ها

<br>


<h3>روش نصب:</h3>

```php
composer require milirezai/milipay
```

نسخه php مور نیاز:

php 8.2 به بعد


نسخه laravel مور نیاز:

laravel 12 به بعد



<br>



<h3>ساختار فایل کانفیگ</h3>




برای انشار فایل کانفیگ از دستور زیر استفاده کنید

```php
php artisan vendor:publish --tag=milipay-config
```




به طور خود کار پکیج یک درگاه رو برای اتصال انتخاب می کنه این درگاه توی فایل کانفیگ برای مقدار پیش فرض مشخص شده

```php
    "defaultDriver" => "zarinpal"
```




یک نمونه کامل از کانفیک یک درگاه پرداخت رو این پایین می بینید


```php 

        'example-driver' => [
            'status' => true, // این فیلد وضعیت فعال بودن یک درگاه رو مشخص می کنه
            'manager' => \Mili\Milipay\Drivers\Zibal\Zibal::class, // namespace کلاس درگاه
            'adapter' => \Mili\Milipay\Response\Adapters\Zibal::class, // این بخش مربوط به ریسپانس هندلر درگاه است
            'payloadBuilder' => \Mili\Milipay\PayloadBuilders\ZibalPayloadBuilder::class, // این بخش مربوط به سازنده دیتای برای ارسال به api درگاه است
            'merchant' => 'zibal', // این مقدار رو باید تویه درگاه پرداختی که قصد استفاده از اون رو دارید ثبت نام و دیافت کنید این مقداری که الان پر شده فقط برای تست از کارکرد درگاه است
            'timeout' => 8, // این فیلد برای مدت زمان طول  درخواست  تا زمان پاسخ  درگاه است
            'retry' => 2, // این بخش تعداد تکرار یه درخواست در صورت تموم شدن زمان درخواست رو نشون میده 
            'api' => [ // تمام چرخه پرداخت توسط فیلد های زیر انجام میشه که از هر کدومش برای یک کار استفاده میشه 
                "request" => "https://gateway.zibal.ir/v1/request", // این مقدار اطاعات رو که شما برای یک پرداخت در نظر گرفتید رو برای درگاه ارسال می کند و یک پاسخ رو بر میگردونه
                "start" => "https://gateway.zibal.ir/start/", // این مقدار کاربر رو به همراه یک شناسه پرداخت به صفحه ای که پرداخت باید انجام بشه هدایت می کنه 
                "verify" => "https://gateway.zibal.ir/v1/verify", // برای برسی پرداخت ها از این مقدار استفاده میشه
                'inquiry' => 'https://gateway.zibal.ir/v1/inquiry', // برای استعلام پرداخت ها از این مقدار استفاده میشه
                "callbackUrl" => 'app/callback' // این مقدار رو هم توی فایل کانفیگ می تونید مقدار دهی کنید و هم هنگام پرداخت با متد ها مختلفی که براش در نظر گرفته شده ، بعد از پرداخت درگاه کاربر رو به این بخش هدایت می کنه
            ],
            'codeMessage' => [ // هر نوع درخواست به سمت درگاه ها شمال یک کد می باشد که از این فیلد برای معنی کردن این کد استفاده میشه
                -1 => 'در انتظار پرداخت',
            ]

        ]


```



<br>



<h3>روش استفاده</h3>

<br>

برای استفاده می تونید از کلاس اصلی و یا فساد آن استفاده کنید
```php
use Mili\Milipay\Milipay;
use Mili\Milipay\Facades\Milipay;
```
<br>

مقدار دهی تنظیمات درگاه برای درخواست :

```php

         // request config
        Milipay::invoice()
            ->driver('zibal') // driver ست کردن
            ->merchant('zibal') // merchant ست کردن
            ->amount(24234) 
            ->callback('callback-url') // callback url ست کردن
            ->apiRequest('zibal-api-request') // api request ست کردن
            ->request();
            
            // verify config
        Milipay::invoice()
            ->payId(4234234)
            ->apiVerify('zibal-api-verify') // api verify ست کردن
            ->verify();
            
            // inquiry config
        $pay = Milipay::invoice()
            ->amount(4234234)
            ->apiStart('zibal-api-start') // api start
            ->request();
        return $pay->pay();

         // request , verify , inquiry , start and callback-url 
         Milipayf::invoice()
            ->amount(2000000)
            ->apis(
                apiStart: 'api-start' , apiVerify: 'api-verify', apiInquiry: 'api-inquiry',
                apiRequest: 'api-request', callback: 'callback-url'
            )->request();


```

<br>
تغییر مقدار پیش فرض درایور و انتخاب درایور دلخواه

```php
Milipay::invoice()
            ->when(function () use ($user){
                return $user->is_active ? true : false;
            })->via(ifTrue: 'zibal', ifFalse: 'zarinpal')
            ->amount(2000000)
            ->request();
or 
Milipay::invoice()
            ->when(function () use ($user){
                return $user->is_active ? true : false;
            })->via(ifTrue: 'zibal')
           ->amount(2000000)
            ->request();

or 
Milipay::invoice()
            ->driver('zibal')
            ->amount(2000000)
            ->request();

```

<br>



<h4>ارسال درخواست پرداخت</h4>


یک نمونه ساده برای اتصال ، ارسال درخواست و مننتقل شدن به درگاه پرداخت

```php
        $pay = Milipay::invoice()
            ->amount(2000000)
            ->description('pay with milipay')
            ->request();
        return $pay->pay();
```
و یا کامل تر
```php
        Milipay::invoice()
            ->amount(24234)
            ->orderId(1)
            ->description('pay with milipay')
            ->mobile('09167516826')
            ->nationalCode(4300453423)
            ->email('milirezaix@gmail.com')
            ->request();
```


شما همچنان می تونید از متد optional() استفاده کنید

این متد چهار مقدار می گیره

```php
        Milipay::invoice()
           ->amount(2000000)
            ->optional(
                orderId: 1, mobile: '09167516826',
                nationalCode: 439908098, description: 'pay with milipay'
            )->request();
```

<br>
<h4>ارسال درخواست تایید</h4>

بعد از پرداخت برای تایید پرداخت می تونید از متد تایید استفاده کنید برای در خواست  نیاز به شناسه پرداخت دارید

```php
    $pay = Milipay::invoice()
        ->payId(424234234234)
        ->verify();
     return $pay->response()->toArray();
```

در بعضی از درگاه ها مثل زرینپال برای درخواست تایید نیاز به مقدار پول پرداخت شده هم وجود دارد و باید ارسال بشه

```php
    $pay = Milipay::invoice()
        ->amount(150000)
        ->payId(424234234234)
        ->verify();
     return $pay->response()->isSuccessful();
```

<br>

<h4>ارسال درخواست استعلام</h4>

برای استعلام پرداخت در صورتی که نیاز داشتید می تونید به صورت پایین رفتار کنید


```php
    $pay = Milipay::invoice()
        ->payId(424234234234)
        ->inquiry();
     return $pay->response()->isSuccessful();
```
<br>
<h4>مدیریت پاسخ در خواست ها </h4>


برای مدیریت پایخ های متد ها و روش های مختلفی وجود دارد، می توان پاسخ ها رو به فرمت های مختلف در یافت کنید


```php

$response = Milipay::invoice()
        ->payId(424234234234)
        ->inquiry();
$response->response()->toArray(); // متد تو ارایه پاسخ رو به صورت آرایه ارسال می کند
$response->response()->toJson(); // متد تو جیسون پاسخ رو به صورت جیسون ارسال می کند
$response->response()->isSuccessful(); // این متد بررسی می‌کند که آیا پیام دریافتی از درگاه پرداخت برابر با موفقیت‌آمیز بودن است یا خیر. در صورت صحیح بودن، مقدار True را برمی‌گرداند
$response->response()->isFailed(); //  این متد سناریوی مخالف متد isSuccessful() را بررسی می‌کند.
$response->response()->getMessage(); // اگر می خوایید پبام ارسال شده از سمت درگاه رو مشاهده کنید
$response->response()->getPayId(); // می‌توان گفت متد getPayId() مهم‌ترین پاسخی است که از درگاه می‌آید. این متد بسته به درگاه‌های مختلف می‌تواند انواع مختلفی داشته باشد. این قسمت برای تأیید و استعلام‌های پرداخت مورد نیاز است، بنابراین حتماً آن را ذخیره کنید تا بعداً برای سایر قسمت‌ها استفاده شود.
$response->response()->getTranslateResponseCode(); // با هر پاسخ به درگاه، کدی تولید و برای ما ارسال می‌شود که نشان‌دهنده وضعیت و نتیجه است، با استفاده از این روش می توان به معنای این کد پی برد.
$response->response()->whenSuccess(function ($response){ // ممکن است بخواهید بسته به پاسخی که از سمت درگاه پرداخت امده است یک عملیات انجام دهید این متد این کارو برای شما انجام مییده این متد برسی میکنه که پاسخی که از سمت در گاه اومده مساوی درست است یا خیر  این متد دو ارگومان میگیره که هر دو از نوع کلوژر هستند این متد برسی میکنه اگر جواب دریافت شده از درگاه مساوی ترو یعنی درست باشد کلوژر اول رو اجرا میکنه واگر مساوی فالس یعنی اشتباه باشد کلوژر دوم رو اجرا می کنه هر کدوم از این کلوژر ها به شی ریسپانس دسترسی دارن و می تونید از ریسپانس ها هم داخل کلوژر ها استفاده کنید
            // run if $response->response()->isSuccessful() == true
        },function ($response){
            // run if $response->response()->isSuccessful() != true
        });
 $response->response()->whenFailed(function ($response){ // این متد هم دقیا کار متد بالا رو انجام میده ولی برعکس یعنی حالت فالس یعنی اشتباه پاسخ درگاه رو برسی میکنه
            // run if $response->response()->isSuccessful() != true
        },function ($response){
            // run if $response->response()->isSuccessful() == true
        });
$response->response()->responseTime(); // میتونید تایم یک درخواست رو ببینید

```

```php
milirezaix@gmail.com
```
