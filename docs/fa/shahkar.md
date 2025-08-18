<div align="right">

# سرویس شاهکار

## معرفی
سرویس شاهکار این امکان را میدهد که با ارسال شماره موبایل و کد ملی ،انطباق اطلاعات وارد شده را بررسی کند.

## نحوه استفاده

### در لاراول
</div>
<div align="left">

```php
use Illuminate\Support\Facades\Rade;

$result = Rade::shahkar('09366125480','0012345678');
```

</div>
<div align="right">

### استفاده مستقیم

</div>
<div align="left">

```php
<?php
use Radeir\Services\RadeServices;

// تنظیمات
$config = [
    'username' => 'your_username',
    'password' => 'your_password',
    'scopes' => ['scope1', 'scope2','shahkar'],
    'baseUrl' => 'https://api.rade.ir/api'
];

// ایجاد نمونه از سرویس
$radeServices = new RadeServices($config);
$radeServices->shahkar('09366125480','0012345678');
// استفاده از سرویس‌ها
try {
   // مستندات سرویس های ارایه شده به تفکیک خدمات در پایین بخش  #سرویس‌ها آمده است
} catch (\Radeir\Exceptions\RadeException $e) {
    // مدیریت خطا
    echo "Error: " . $e->getMessage();
}
```

</div>
<div align="right">

## پارامترهای ورودی

کد ملی (اگر با ۰۰ شروع میشود آنرا لحاظ کنید.)

شماره موبایل را با فرمت `09....` وارد کنید

## خروجی

شما میتوانید `trackID` را ذخیره کنید، چراکه این پارامتر تنها پارامتر ذخیره شده در سرور رده است و قابلیت پیگیری تنها با `trackID` است.

</div>
<div align="left">

```json
{
	"trackID": "b6914995-f6ee-4ec0-8d65-d86a696227bb",
	"result": true // true | false
}
```

</div>
<div align="right">

## خطاهای احتمالی

| کد خطا | پیام                     | توضیحات                       |
|--------|--------------------------|-------------------------------|
| 422    | شماره موبایل نامعتبر است | شماره موبایل معتبر نیست.      |
| 422    | کد ملی نامعتبر است       | کد ملی معتبر نیست.            |
| 401    | خطای احراز هویت          | توکن نامعتبر یا منقضی شده است |

</div>
