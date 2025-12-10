## معماری و ساختار داخلی 


## مستندات
- [اصلی](../README.md)
- [فارسی](README_FA.md)



<h3>Folder structure</h3>


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


همان طور که در بالا مشخص است این پکیج ساختاری کاملا استاندارد رو برای یک پکیج پرداخت رو دارد ولی در طراحی و نوشتن اون وسواس و نظم خاصی رو در نظر گرفتم تا همه موارد به شکلی درست و عالی کار کنند
 
ساختار پوشه ها و کلاس ها کاملا مشخص است که چه کاری رو بر عهده دارند ولی باز برای هر کدام توضیحات کوتاهی رو میگم

تمام کلاس ها مثل همه پکیج ها داخل پوشه اس ار سی قرار دارند که کامپوز برای لود کردن کلاس ها به درستی عمل کند و با لاراول همخونی داشته باشه

داخل این پوشه باز هم پوشه های مختلفی رو مشادهده می کنید 

<h3>Config /</h3>

داخل این پوشه کلاس ConfigGateway  وجود داره که برای برقرای ارتباط و خوندن فایل کانفیگ درگاه ها و گرفتن مقادیر و مدیریت کننده های هر درگاه ساخته شده این کلاس متد های مختلفی داره که در صورت نیاز می تونید از اونها استفاده کنید

برای استفاده از راحت از این کلاس می تونید از هلپر فانگشن زیر استفاده کنید که یک نمونه از کلاس رو بر میگردونه

```php
gateConfig(): ConfigGateway
```

و یا می توانید از Facade ان استفاده کنید


```php
use MiliPay\Facade\MiliPayConfig;


MiliPayConfig::class;
```

method setFileConfigPath(): self :

این متد برای ساخت مسیر فایل کانفیگ نوشته شده است تا برای انتشار فایل کانفیگ یک مسیر درست رو به لاراول معرفی کنه


method getFileConfigPath(): string :

از این متد برای گرفتن مسیر فایل کانفیگ استفاده میشه



```php
gateConfig()->setFileConfigPath()->getFileConfigPath();
```

method driver(string $driver): self :

این متد نام درگاهی رو که میخایید به کانفیگ اون دسترسی داشته باشید رو ازتون دریافت می کنه


method all():array :

این متد تمام اطلاعاتی که یک درگاه درون ایل کانفیگ دارد رو برای شما ارسال می کند 


```php
use MiliPay\Facade\MiliPayConfig;


MiliPayConfig::driver('zibal')->all();
```


method apis():array :

این متد api های یک درگاه رو گرفته و برای شما ارسال می کند

```php
gateConfig()->driver('zibal')->apis();
```


method settings():array :


این متد اطلاعات تنظیمات درگاه رو ارسال می کند


```php
gateConfig()->driver('zibal')->settings();
```


method status():bool :


 این متد وضعیت درگاه رو ارسال می کند


```php
gateConfig()->driver('zibal')->status();
```

method manager():string :

این متد ادرس کلاس مدیریت کننده درگاه رو برای ما ارسال می کند

```php
gateConfig()->driver('zibal')->manager();
```




method codeMessage(int $code):string|null :


این متد یک کد از شما گرفته و داخل ارایه کد مسیج درگاه به دنبال معنی اون کد میگرده


```php
gateConfig()->driver('zibal')->codeMessage(3);
```


method name():string :


این متد نام درگاه رو برای ما ارسال می کند

```php
gateConfig()->driver('zibal')->name();
```


method drivers():array :

این متد لیست درایوری ها پشتیبانی شده رو ارسال می کنه


```php
gateConfig()->driver('zibal')->drivers();
```


method has():bool :

اگر دایور داداه شده داخل درایور های موجود باشه مقدار درست و اگر نباشد مقدار اشتباه رو برر می گردونه


```php
gateConfig()->driver('zibal')->has();
```


method defaultDriver():string :


این متد درایور پیش فرض داخل فایل کانفیگ رو ارسال می کند


```php
use MiliPay\Facade\MiliPayConfig;

MiliPayConfig::defaultDriver();
```


<h3>ErrorHandler /</h3>

داخل این پوشه یک سیستم مدیریت خطای خوب با قابلیت هی مختلقی دارد که شما جدای از این پکیج هم می تونید داخل بخش های که لازم داشتید از اون استفاده کنید

برای استفاده از این کلاس می تونید به دو به روش عمل کنید:

استاده از هلپر فانگشتن

```php
errorHandler(): PaymentErrorHandler
```

و یا می توانید از Facade ان استفاده کنید


```php
use MiliPay\Facade\MiliPayError;


MiliPayError::class;
```

method set(string $error): self :

منتن خطا توسط این متد گرفته می شود 


method  get(): string : 

برای گرفتن خطا می توان از این متد استفاده کرد


```php
use MiliPay\Facade\MiliPayError;


MiliPayError::set('error in pay')->get();
```


method toException(): self :

ممکن است بخواهید خطا رو به یک اکسپشن تبدیل کنید 


```php
errorHandler()->set('error in pay')->toException();
```


method has(): bool :

برای برسی وجود خطا از این متد استفاده می شود

```php
use MiliPay\Facade\MiliPayError;


MiliPayError::has();
```


method log(): self :

برای لاگ گرفتن خطا می تونیز قبل از انتخاب نوع لاگ این متد رو صدا بزنید

```php
errorHandler()->set('error in pay')->log()->warning(); // log warning

errorHandler()->set('error in pay')->log()->info(); // log info

errorHandler()->set('error in pay')->log()->error(); // log error
```

نمونه کامل ست کردن خطا و لاگ گرفتن و ست کردن یک اکسپشن


```php
use MiliPay\Facade\MiliPayError;


MiliPayError::set('error in request api')
             ->log()->error()
             ->toException()
```


<h3>Facade /</h3>

این پوشه دارای فساد های پکیج است که برای ساخت انها از فساد لاراول و برای ساختل کلاس های هندل کننده انها از سرویس کانینتر لاراول استفاده شده



<h3>Gateways /</h3>

این پوشه کلاس های پایه هر درگاه پرداخت رو درون خودش تویه پوشه های مربوط به هر درگاه نگه داره می کنه 

ساختار پایه یک کلاس مدیریت کننده درگاه به شکل زیر است


```php
namespace MiliPay\Gateways\Zibal;

use MiliPay\Requester\BasicRequester;
use MiliPay\Response\GatewayResponseHandler;
use MiliPay\ResponseAdapters\ZibalAdapter;
use MiliPay\Support\Contract\Gateway;
use MiliPay\Support\Contract\ResourceData;
use MiliPay\Support\Contract\ResponseAdapterHandler;
use MiliPay\Support\Trait\OptionalData;

class GatewayNameManager extends BasicRequester implements ResourceData, Gateway
{
    use OptionalData;
    protected string $driver = 'driverName';
    protected string $merchant = 'merchantId';

    public function __construct(
        protected GatewayResponseHandler $responseHandler,
        protected ResponseAdapterHandler $adapter
    ){}

    public function amount(int $amount): self
    {
        if ($amount > 0){
            $this->amount = $amount;
            return $this;
        }
       errorHandler()
           ->set('amount must be greater than zero.')
           ->log()
           ->info()
           ->toException();
    }

    public function request(): self
    {
        $this->setDefaultConfig();
        $response = $this->sendRequest();
        $this->response = $response;
        return $this;
    }

    public function verify(): self
    {
        $this->setDefaultConfig();
        $response = $this->sendRequestVerify();
        $this->response = $response;
        return $this;
    }

    public function inquiry(): self
    {
        $this->setDefaultConfig();
        $response = $this->sendRequestInquiry();
        $this->response = $response;
        return $this;
    }
    protected function adapter(): ZibalAdapter
    {
        return $this->adapter->init($this->response);
    }

    public function response():GatewayResponseHandler
    {
        return $this->responseHandler->init($this->adapter());
    }

    public function pay()
    {
        if ($this->response()->isSuccessful())
            return $this->start();
    }
    public function sendRequest(): array
    {
       // base
    }

    public function sendRequestVerify()
    {
       // base
    }

    public function start()
    {
        return redirect()
            ->away($this->getApiStart().$this->response()->getPayId());
    }

    public function sendRequestInquiry()
    {
        // base
    }

    public function buildRequestData(): array
    {
        // base
    }

    public function buildVerifyRequestData(): array
    {
       // base
    }

    public function buildInquiryRequestData(): array
    {
       // base
    }
    
}

```

اسم متد ها کاملا نشون دهنده کار متد هاست

همه کلاس های مدیریت کننده درگاه ها از یک بیس کلاس ارث بری می کنند که همگی رفتاری یک سان رو داشته باشند


این کلاس از دو اینتر فیس استفاده می کند یکی برای ساختار دیتا های ارسالی و دیگری برای بیس اطاعاتی که هر درخواست پرداخت نیاز دارد 

درون متد سازنده این کلاس یک اینتر فیس و یک کلاس تزریق شده است

class GatewayResponseHandler::class :


این کلاس همان کلاس اصلی است که در اخر شما از ان برای دریافت پاسخ ها و مدیریت انها استاده می کنید این کلاس یک کلاس پایه است و از نوع درگاه و نوع پاسخ ها اصلا خبری ندار و برایش هم تقاوتی ندارد که قالب پاسخ های درگاه ها با هم متقاوت باشد در واقع پرازش پاسخ ها اصلا در این کلاس انجام نمی شود فقط یک کلاس واسط و سطح بالا تر است


interface class ResponseAdapterHandler :

هر درگاه برای پردازش پاسخ های خرد به یک کلاس نیاز دارد تا پاسخ رو دریافت کرده و پردازش کند این کلاس ها باید همگی این اینترفیس رو پباده سازی کنند 


ریسپانس هندلر اصلی از این کلاس های آداپتور برای ارسال خروجی پاسخ ها استفاده می کند اینجوری از دستورات شرطی تو در تو چلوگیری می کنیم و هر درگاه برای پردازش می توند رفتار متفاوتی رو داشته باشه


تزریق این اینترفیس و کلاس پیاده کننده اون و تزریق ریسپانس هندلر اصلی رو توسط سرویس کانتینتر لاراول اتنجام دادم



<h3>Manager /</h3>

 این پوشه  دارای کلاس اصلی است که ما داخل کد های خودمون برای پرداخت و سایر عملیات  ها ازش استفاده می کنیم این کلاس از پترن فکتوری برای ساخت کلاس ها استفاده می کند  



<h3>Requester /</h3>


 این یک کلاس بیس است که همه درگاه باید از اون ازث ببرن هر چند  چیز زیادی براشون نزاشته ولی باز چند تا متد هس که باید پیاده سازی کنن و پراپرتی هایی که اونجا جمع شدن که تو همه درگاه تکرار میشن این کلاس هم یه اینتر فیس رو خواسته پیاده سازی کنه ولی اونو به شکل ابسترکت در اورده و پیاده سازیشوگذاشته واسه کلاس های فرزند


<h3>Response /</h3>



خوب این پوشه یکی از مهم ترین هاست که اگه پکیج رو باز نکنید اصلا از وجودش خبر دار نمیشید در حالی که تمام پاسخ ها و متد هاش از اینجا رد میشند بعد به دست ما میرسن این کلاس هیچ منطق رو برای پردازش پاسخ ها پیاده سازی نمی کنه میتونست این کار رو انجام بده ولی بعدش اگه کلاس رو باز میکردید  با یه کلاس ۴۰۰ خطی مواجه میشدید و دستورات شرطی تو در تو و زشت و اینجوری از کد تمیز دور میشدیم خوب میشد یه جوری یه کلاس طولانی رو پذیرفت و اصن ندید بگیرم ولی مشکل اصلی از جایی شروع میشد که یک درگاه دیگه اضافه میکردم و خدایی نکرده اون درگاه قالب پاسخ ارسالیش متقاوت بود اون موقع باید از اول همه متد ها رو مینوشتم اگه درگاه این بود این کارو انجام بده و اگه نبود چکار کنه اینجوری اصلا با عقل جور در نمیاد و منم تصمیم گرفتم این کلاس اصلان کاری به پردازش داده ها نداشته باشه و فقط پلی باشه بین کلاس هندل کننده پاسخ هر درگاه و ما همین و بس




<h3>ResponseAdapters /</h3>

اینجا محلی اون ریسپانس هندلر های هر درگاه هست که اون بالا بهش اشاره کردم برای پیاده سازی منطق پاسخ های از پترن اداپتور استفاده کردم دلیلیشم بالا تر گفتم این کلاس ها کار پردازش دیتا ها دریافتی از سمت درگاه ها رو انجام میدن بدون هیچ منطق سخت هر اداپتور یک درگاه و تمام 



<h3>Support /</h3>

اینجا یه پوشه جذابه که هرچی بخوایید توش هست مثل فروشگاه های بزوگ می مونه از فانگشن بگیر تا اینترفیس تا تریت هرچی که امکان تکرارش وجود داشته و یه ویژگی به حساب می اومده اینجا قرار گرفته

قرار داد ها تویه پوشه کانترکت همین جا هستند نیاز به معرفی و کار قرار داد ها نمیبینم چون اگه تا اینجا اومدی حتما میدونی کارش چیه

فایل هلپر فانگشن هم اینجاس شاید خواستید بدونید

و میرسیم به تریت ها که بخش ها و متد های خیلی کاربردی و میشه گفت مهمی هستند اینجا می تونید تریت های برای مدیریت کننده درگاه ها ببینید همون کلاس که پترن فکتوری رو اجرا کرده ، میتونید متد های اپشنایلی رو ببینید که میتونستید توسط اون ها اطلاعات اضافی همراه درخواست پرداخت خودتون برای درگاه ارسال کنید  و یه تریت دیگه هم هست که کلاس مدیریت کننده ساخت درگاه ها از اون استفاده می کننه تا مطمعا بشه که درگاه ها فعال هستند با خیر


<h3>doc /</h3>


داکیومنت فارسی و همین داکیومنتی که دارید میخونید رو داخلش می تونید ببینید


<h3>pay.php</h3>

این فایل کانفیگی هست که با دستوری که بهتون گفتم میتونید انتشارش بدید توی پوشه کانفیگ پروژه خودتون



<h3>PaymentServiceProvider::class</h3>

برنامه نویسی و ساخت اینجور پکیج ها برای لاراول بدون استفاده از سروییس پروایدر و سرویس کانتینر خود لاراول عملا سخت میشه هر چند درک کردن این دوتا سرویس هم خودش کار آسونی نیست ولی باز بهتر از نوشتن کد های خودمونه این کلاس توسط کامپوزر ثبت نام میشه و نیاز به ثبت دستی شما نیس، این کلاس کار های مختلفی برای پکیج انجام میده، ثبت نام فایل کانفیگ اینجام انجام میشه و کارای انتشارش هم همین طور بعدش شما به یه دستور ساده میتونید فایل کانفیگ روی توی پروژه خودتون ببینید،کارا ها تزریق وابستگی هایی که توی متد های سازنده بعضی کلاس ها  که خودمون ایجاد کردیم رو هم باید اینجا انجام بدیم که اگه دنبال کد تمیز نبودیم اصلا با این بخش روبه رو نمیشدیم ولی بگذریم  



<h3>جرخه درخواست پراخت</h3>

خوب الان باید راجب چرخه یک درخواست پرداخت بگم

همه چی از کلاس میلی پی شروع میشه وقتی شما از شی این کلاس متد گیت رو صدا میزنید این متد برسی می کنه که ابا قبلش شما در گاه رو مشخص کردید یا خیر اگر مشخص کرده باشد که از درگاه شما استفاده می کنه اگر همه مشخص نکرده باشد که این کلاس توسط یک متد خودش این کارو انجام میده واز کلاسی که برای گرفتن کانفیگ نوشته بودم استفاده می کنه و از روش متد دیفالت درایور رو صدا میزنه و درایور پیش فرض رو میگیره و بعدش کلاس این کلاس فکتوری توسط یکی متد دیگه خودش میاد و ادرس کلاس مدیریت کننده درگاه پیش فرض رو میگیره و دوباره از کلاس گیت وی کانفیگ برای این کار استفاده می کنه و ادرس کلاس درست رو میگیره و متد گیت برای ساخت کلاس مدیریت کننده درگاه از سرویس کانتینر لاراول برای ساخت کلاس استفاده می کنه و مارو به اون وصل می کنه از الان به بعد ما توی کلاس اصلی درگاه هستیم و میتونیم هر کاری مد نظومون بود رو انجام بدیم از روش متد های که توی روش استفاده گفتم صدا میزنیم ترتیب صدا زدن متد هایی که حکم اطلاعت پرداخت رو دارن اصن مهم نیس ولی نباید بعد از متد های درخواست،تایید و استعلام هیچ متد اطلاعاتی رو صدا بزنید بعد از پر کردن اطلاعات پرداخت حالا به فرض ما متد درخواست رو صدا میزنیم این متد به این صورت عمل می کنه که ابتدا متد ست دیفالت کانفیگ رو صدا میزنه که تا کلاس کانفیگ پیش فرض رو در صورتی که شما خودتون ارسال  نکرده باشید رو پر کنه اگر خودتن مقداری رو پر کرده باشید مقدار شما اولیت محسوب میشه ودیگه از کانفیگ نمی خونه اون مقدار رو بعدش متد ارسال درخواست رو صدا میدنه این متد ارسال درخواست در واقع پایین ترین یخش هست و خود این متد از متدی که برای ساخت بدنه درخواست ها در نظرگرفته شده استفاده می کنه و بدنه مورد نظرشو میگیره این بدنه درخواست با توجه به اطلاعاتی که شما برای پرداخت خودتون ارسال کردید رو میسازه بعدش دوباره برگردیم توی متد ارسال درخواست و اینجا پاسخ در خواست رو تویه پراپرتی دیسپانس ذخیره می کنیم و در اخر یک شی از کلاس رو ریترن می کنیم بعد از این ما دو کار میتونیم انجام بدیم اول اینکه اگه بخاییم به پاسخ درخواست دسترسی داشته باشیم یا اونو ذخیره کنیم باید متد ریسپانس رو از روی شی درخواست صدا بزنیم و پاسخ رو دریافت کنیم این متد از ریسپانس هندلر داخلی هر درگاه برای پردازش پاسخ ها استفاده می کنه ولی اگر بخاییم مستقیم به درگاه پرداخت هدایت بشیم باید از روی شی درخواست متد پی رو صدا بزنیم


<h3>نقشه راه آینده</h3>


برای نشقه و بهتره بگم بخش های و، ویژگی های که میخام در ورژن های بعدی اضافه کنم اینکه که میخام بتونید با یک دستور ساده یک گیت وی جدید رو اضافه کنید و همراش هم کلاس اصلی و ریسپانس هندلر و هم کانفیگ پیش فرض اون درگاه ساخته بشه



خوشخال میشم از این پکیج استفاده کنید و نظرتونو برام بفرستید 

همیشه از اخرین نسخه استفاده کنید 


```php
milirezaix@gmail.com
```
