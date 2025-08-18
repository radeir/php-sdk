<div align="right">

# کیت سرویس‌های رده - Rade SDK


## معرفی
این پکیج امکان استفاده از سرویس‌های شرکت رده برای تبدیل و استعلام را برای برنامه‌ها با زمینه **PHP** و **Laravel** فراهم می‌کند.

برای استفاده سازمانی با همکاران ما از طریق پنل پشتیبانی و یا ایمیل با ما تماس بگیرید.

-  [وبسایت رده](https://rade.ir)
- [پنل کاربری رده](https://my.rade.ir)
- [support@rade.ir](mailto:support@rade.ir)
- [English Documents](README.md)

## نصب و راه‌اندازی

برای نصب از طریق `composer` استفاده کنید:
</div>
<div align="left">

```bash
composer require radeir/sdk
```
</div>
<div align="right">

## نحوه استفاده

### استفاده در PHP خام

</div>
<div align="left">

```php
<?php
use Radeir\Services\RadeServices;

// تنظیمات
$config = [
    'username' => 'your_username',
    'password' => 'your_password',
    'scopes' => ['scope1', 'scope2'],
    'baseUrl' => 'https://api.rade.ir/api'
];

// ایجاد نمونه از سرویس
$radeServices = new RadeServices($config);

// استفاده از سرویس‌ها
try {
   // مستندات سرویس‌های ارائه شده به تفکیک خدمات در بخش #سرویس‌ها آمده است
} catch (\Radeir\Exceptions\RadeException $e) {
    // مدیریت خطا
    echo "Error: " . $e->getMessage();
}
```
</div>
<div align="right">

### استفاده در Laravel

#### ۱. انتشار فایل تنظیمات:

</div>
<div align="left">

```bash
php artisan vendor:publish --provider="Radeir\Provider\RadeServiceProvider"
```
</div>
<div align="right">

#### ۲. تنظیم متغیرهای محیطی در فایل `.env`:

</div>
<div align="left">


```
RADE_USERNAME=your_username
RADE_PASSWORD=your_password
RADE_SCOPES=scope1,scope2
RADE_BASE_URL=https://api.example.com
```
</div>
<div align="right">

#### ۳. استفاده با Facade در لاراول:
</div>
<div align="left">

```php
<?php
use Radeir\Facade\Rade;

// تبدیل شماره کارت به شبا
$ibanInfo = Rade::cardToIban('6037991234567890');

// تبدیل شماره کارت به شماره حساب
$depositInfo = Rade::cardToDeposit('6037991234567890');

   // مستندات سرویس های ارایه شده به تفکیک خدمات در پایین بخش  #سرویس‌ها آمده است

```
</div>
<div align="right">

#### ۴. استفاده با تزریق وابستگی یا Dependency Injection:
</div>
<div align="left">

```php
<?php
use Radeir\Services\RadeServices;

class MyController
{
    public function index(RadeServices $radeServices)
    {
       // مستندات سرویس های ارایه شده به تفکیک خدمات در پایین بخش  #سرویس‌ها آمده است
        $ibanInfo = $radeServices->cardToIban('6037991234567890');
        return response()->json($ibanInfo);
    }
}
```
</div>
<div align="right">

## سرویس‌ها

پکیج حاضر امکان استفاده از سرویس‌های زیر را فراهم می‌کند:

 **برای اطلاعات بیشتر در مورد مدیریت و ذخیره توکن به [مستندات مدیریت توکن](docs/fa/token-manager.md) مراجعه کنید.**

- [کارت به شبا](docs/fa/card-to-iban.md)
- [کارت به حساب](docs/fa/card-to-deposit.md)
- [حساب به شبا](docs/fa/deposit-to-iban.md)
- [استعلام شبا](docs/fa/iban-inquiry.md)
- [انطباق شماره شبا با کد ملی](docs/fa/iban-owner-verification.md)
- [شاهکار(انطباق کد ملی با شماره موبایل)](docs/fa/shahkar.md)


## مشارکت در پروژه

برای اطلاع از نحوه مشارکت در این پروژه به [راهنمای مشارکت](docs/fa/contributing.md) مراجعه کنید.

</div>
