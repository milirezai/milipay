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


همه چی از وقتی شروع میشه که شما کلاس میلی پی رو صدا میزنید مهم نیس به چه صورت صدا میزنید خوب بعدش این کلاس چند تا متد مختلف برای استفاده بهتون میده که توجه زمان و مکان خودش توضیح دادم و دیگه اینجا نیازی نیست بلاخره شما از طریق کلاس میلی پی به یکی از درایور ها یعنی همون کلاس مدیریت کننده یک درگاه پرداخت وارد می شوید حلا باید هدفتون رو مشخص کنید که برای انجام چه عملیاتی به درگاه میخایید درخواست بفرستید پرداخت،تایید پرداخت و یا استعلام یک پرداخت، خوب بعد از مشخص شده هدفتون شما باید بدونید برای هد هدف چه اطلاعاتی رو باید بفرستید ، بارای دخواست های تایید درگاه ها رفتار های متاوتی رو دارند بعضی ها برای تایید فقط نیاز به شناسه پرداخت دارن بعضی ها هم شناسه پرداخت و هم مبلغ پرداخت شده رو از شما میخان شما دوتا کار میتونید انجام بدید برای همه درگاه ها هم شناسه پرداخت رو بفرستید و هم مبلغ و یا می تونید برید برسی کنید که کدوم درگاه ها برای تایید نیاز به مبلغ دارن ، برای استعلام پرداخت ها همه درگاه فقط نیاز به شناسه پرداخت دارن ، و برای پرداخت که اصلی ترین هدف و عملیاتی هست که می تونید انجام بدید اصلی ترین دیتایی که باید ارسال کنید مبلغ هست بعضی درگاه ها نیاز به توضیحات هم دارن که بنظرم برای همه درگاه یک توضیح کوتاه بفرستید و بقیه دیتا ها برای پرداخت ضروری نیستند و فرستادنشون بسته به انتخاب خودتونه،خوب حالا ما هم هدفمون مشخص شد و هم میدونیم برای هر علملیات چه دیتا هایی باید بفرستیم بعدش بسته به عملیات وارد یکی از متد های درخواست هنرلر میشیم اونجا فقط درخواست فرستاده میشه قالب دیتا های تویه یک متد دیگه ساخته میشه این درخواست هندلر ها درخواست  مارو میفرستن سمت درگاه و یک پاسخ دریافت میکنن، برای هر کدوم از هدف های عملیات یک متد در نظر گرفته شده تویه همین متد پاسخ درخواست ریسپانس هندلر رو تویه پراپرتی ریسپانس زخیره می کنیم و شی کلاس رو بر میگردونیم حلا ما در ادامه این زنجیره متد ها دوتا مسیر رو میتونیم در نطر بگیرم و استفاده کنیم یا میخواییم به سمت درگاه بریم و عملیات رو تموم کنیم یا ن میخاییم پاسخ رو ذخیره کنیم  و یا کاری دیگه، برای رفتن به سمت درگاه باید متد پی رو از روی شی صدا بزنیم اینجوری به سمت درگاه هدایت می شیم، اگر هم خواستیم پاسخ رو دریافت کنیم از روی شی متد ریسپانس رو صدا میزنیم این متد یک نمونه از کلاس ریسپانس هندلر اصلی رو ارسال می کنه که خیلی حرفه ای نوشته شده و متد های خیلی زیادی هم داره برای استفاده


<h3>نقشه راه آینده</h3>


برای نشقه و بهتره بگم بخش های و، ویژگی های که میخام در ورژن های بعدی اضافه کنم اینکه که میخام بتونید با یک دستور ساده یک گیت وی جدید رو اضافه کنید و همراش هم کلاس اصلی و ریسپانس هندلر و هم کانفیگ پیش فرض اون درگاه ساخته بشه



خوشخال میشم از این پکیج استفاده کنید و نظرتونو برام بفرستید 

همیشه از اخرین نسخه استفاده کنید 


```php
milirezaix@gmail.com
```


