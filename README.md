# Rade Services SDK

## Introduction
This package provides the ability to use Rade Company's conversion and inquiry services for **PHP** and **Laravel** applications.

For organizational use, please contact our colleagues through the support panel or email.

- [Rade Website](https://rade.ir)
- [Rade User Panel](https://my.rade.ir)
- [support@rade.ir](mailto:support@rade.ir)
- [مستندات فارسی](README_FA.md)

## Installation

Install via `composer`:

```bash
composer require radeir/sdk
```

## Usage

### Using in Plain PHP

```php
<?php
use Radeir\Services\RadeServices;

// Configuration
$config = [
    'username' => 'your_username',
    'password' => 'your_password',
    'scopes' => ['scope1', 'scope2'],
    'baseUrl' => 'https://api.rade.ir/api'
];

// Create service instance
$radeServices = new RadeServices($config);

// Use services
try {
   // Documentation for each service is available in the Services section below
} catch (\Radeir\Exceptions\RadeException $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}
```

### Using in Laravel

#### 1. Publish the configuration file:

```bash
php artisan vendor:publish --provider="Radeir\Provider\RadeServiceProvider"
```

#### 2. Set environment variables in `.env` file:

```
RADE_USERNAME=your_username
RADE_PASSWORD=your_password
RADE_SCOPES=scope1,scope2
RADE_BASE_URL=https://api.example.com
```


#### 3. Using the Facade in Laravel:

```php
<?php
use Radeir\Facade\Rade;

// Convert card number to IBAN
$ibanInfo = Rade::cardToIban('6037991234567890');

// Convert card number to deposit account
$depositInfo = Rade::cardToDeposit('6037991234567890');

// Documentation for each service is available in the Services section below

```

### 4. Using Dependency Injection:

```php
<?php
use Radeir\Services\RadeServices;

class MyController
{
    public function index(RadeServices $radeServices)
    {
        // Documentation for each service is available in the Services section below
        $ibanInfo = $radeServices->cardToIban('6037991234567890');
        return response()->json($ibanInfo);
    }
}
```


## Services

This package provides the following services:

- [Bank card number to Iban](docs/en/card-to-iban.md)
- [Bank card number to Deposit account](docs/en/card-to-deposit.md)
- [Deposit account to Iban](docs/en/deposit-to-iban.md)
- [Iban inquiry](docs/en/iban-inquiry.md)
- [Iban owner verification](docs/en/iban-owner-verification.md)
- [Shahkar](docs/en/shahkar.md)

For more information about token management and save, please refer to the
[Token Management Documentation](docs/en/token-manager.md).

## Contributing

For information on how to contribute to this project, please refer to the
[Contribution Guide](docs/en/contributing.md).

