php artisan vendor:publish --provider="YOoSlim\TestK\Providers\ServiceProvider"

Import necessary entities
use YOoSlim\TestK\Payment\Requests\RegisterRequest;
use YOoSlim\TestK\Utils\CurrencyEnum;
use new YOoSlim\TestK\Utils\CreditCard;
use YOoSlim\TestK\Facades\Payment;
use YOoSlim\TestK\Payment\Providers\PayPalPaymentProvider;

Create a new payment request
$request = new RegisterRequest(
	54.25,
	CurrencyEnum::EURO,
	CreditCard('123456789123456')
)

Register the payment request
Payment::create($request)
	-useProvider(PayPalPaymentProvider::class)
	->register()

Get a payment details
Payment::