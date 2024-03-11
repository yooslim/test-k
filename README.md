# Introduction
This is a practical technical assessment as part of a hiring process.

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
use YOoSlim\TestK\Payment\Providers\StripePaymentProvider;
```

# Create a new payment request and register it
```php
$request = new RegisterRequest(
	100.00,
	CurrencyEnum::EURO,
	new CreditCard('4000056655665556')
)

$details = Payment::useProvider(PayPalPaymentProvider::class)
	->setRequest($request)
	->register()

// Or use default provider
$details = Payment::useDefaultProvider()
	->setRequest($request)
	->register()
```

# Get a payment details
```php
$request = new DetailsRequest(
	'PAYPAL98765ZYX'
)

$details = Payment::useProvider(PayPalPaymentProvider::class)
	->setRequest($request)
	->get()
```
## Authors
- [@Slimani Youcef](https://www.github.com/yooslim)
