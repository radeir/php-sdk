# Shahkar Service

## Introduction
The Shahkar service provided by Rade allows you to verify the correctness of information by sending a mobile, national ID of the user.

## Usage

### In Laravel

```php
use Illuminate\Support\Facades\Rade;

$result = Rade::shahkar('09366125480','0012345678');
```

### Direct Usage

```php
<?php
use Radeir\Services\RadeServices;

// Configuration
$config = [
    'username' => 'your_username',
    'password' => 'your_password',
    'scopes' => ['scope1', 'scope2','shahkar'],
    'baseUrl' => 'https://api.rade.ir/api'
];

// Create service instance
$radeServices = new RadeServices($config);
$radeServices->shahkar('09366125480','0012345678');
// Use the service
try {
   // Documentation for services provided is detailed in the #Services section below
} catch (\Radeir\Exceptions\RadeException $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}
```

## Input Parameters

National ID (If it starts with 00, include it)

Mobile `09.....`


## Output

You should save the `trackID` as it is the only parameter stored on the Rade server and can be used for tracking purposes.

```json
{
	"trackID": "b6914995-f6ee-4ec0-8d65-d86a696227bb",
	"result": true // true | false
}
```

## Possible Errors

| Error Code | Message              | Description               |
|------------|----------------------|---------------------------|
| 422        | Invalid Nationality  | National ID is not valid. |
| 422        | Invalid Mobile       | Mobile not valid.         |
| 401        | Authentication error | Invalid or expired token  |
