# After installation

```bash
php artisan vendor:publish --provider="YOoSlim\TestK\Providers\ServiceProvider"
```

# Import necessary entities
```php
use YOoSlim\TestK\Payment\Requests\RegisterRequest;
use YOoSlim\TestK\Payment\Requests\DetailsRequest;
use YOoSlim\TestK\Utils\CurrencyEnum;
use YOoSlim\TestK\Utils\CreditCard;
use YOoSlim\TestK\Facades\Payment;
use YOoSlim\TestK\Payment\Providers\PayPalPaymentProvider;
```

# Create a new payment request and register it
```php
$request = new RegisterRequest(
	54.25,
	CurrencyEnum::EURO,
	CreditCard('123456789123456')
)

$details = Payment::create($request)
	-useProvider(PayPalPaymentProvider::class)
	->register()

// Or use default provider
$details = Payment::create($request)
	-useDefaultProvider()
	->register()
```

# Get a payment details
```php
$request = new DetailsRequest(
	'9c7430ae-9a03-11ee-b9d1-0242ac120002'
)

$details = Payment::get($request)
```
## Authors
- [@Slimani Youcef](https://www.github.com/yooslim)