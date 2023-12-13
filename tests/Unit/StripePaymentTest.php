<?php

namespace YOoSlim\TestK\Tests\Unit;

use App\Console\Kernel;
use Mockery;
use YOoSlim\TestK\Exceptions\InvalidCredentialException;
use YOoSlim\TestK\Exceptions\PaymentProcessException;
use YOoSlim\TestK\Exceptions\ProviderConnectionException;
use YOoSlim\TestK\Facades\Payment;
use PHPUnit\Framework\TestCase;
use YOoSlim\TestK\Exceptions\PaymentNotFoundException;
use YOoSlim\TestK\Payment\Providers\StripePaymentProvider;
use YOoSlim\TestK\Payment\Requests\DetailsRequest;
use YOoSlim\TestK\Payment\Responses\PaymentDetails;
use YOoSlim\TestK\Utils\CreditCard;
use YOoSlim\TestK\Utils\CurrencyEnum;
use YOoSlim\TestK\Payment\Requests\RegisterRequest;

class StripePaymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_payment_positive_response_is_correctly_handled()
    {
        $cardNumber = 4242424242424242;
        $amount = 150.00;
        $identifier = 'STRIPE12345XYZ';
        $currency = CurrencyEnum::DOLLAR;

        $paymentProvider = Mockery::mock(StripePaymentProvider::class)->makePartial();

        $paymentProvider->shouldReceive('stripePaymentProcess')
            ->andReturn([
                'id' => $identifier,
                'status' => 'pending',
                'redirect' => '',
            ]);

        try {
            $request = new RegisterRequest(
                $amount,
                $currency,
                new CreditCard($cardNumber)
            );

            $paymentDetails = Payment::useProvider($paymentProvider)
                ->setRequest($request)
                ->register();

            $this->assertInstanceOf(PaymentDetails::class, $paymentDetails);

            // Assert response
            $this->assertEquals('pending', $paymentDetails->status);
            $this->assertEquals($identifier, $paymentDetails->id);
            
            // Assert payment requests
            $this->assertEquals($amount, $paymentDetails->request->amount);
            $this->assertEquals($currency, $paymentDetails->request->currency);
            $this->assertEquals($cardNumber, $paymentDetails->request->card->getCardNumber());
        } catch (InvalidCredentialException | PaymentProcessException | ProviderConnectionException $e) {

        }
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_payment_positive_details_response_is_correctly_handled()
    {
        $cardNumber = 4242424242424242;
        $amount = 150.00;
        $identifier = 'STRIPE12345XYZ';
        $currency = CurrencyEnum::DOLLAR;

        $paymentProvider = Mockery::mock(StripePaymentProvider::class)->makePartial();

        $paymentProvider->shouldReceive('stripeGetPayment')
            ->andReturn([
                'id' => $identifier,
                'status' => 'pending',
                'redirect' => '',
                'currency' => $currency->value,
                'card' => $cardNumber,
                'amount' => $amount
            ]);

        try {
            $request = new DetailsRequest(
                $identifier,
            );

            $paymentDetails = Payment::useProvider($paymentProvider)
                ->setRequest($request)
                ->get();

            $this->assertInstanceOf(PaymentDetails::class, $paymentDetails);

            // Assert response
            $this->assertEquals('pending', $paymentDetails->status);
            $this->assertEquals($identifier, $paymentDetails->id);
            
            // Assert payment requests
            $this->assertEquals($amount, $paymentDetails->request->amount);
            $this->assertEquals($currency, $paymentDetails->request->currency);
            $this->assertEquals($cardNumber, $paymentDetails->request->card->getCardNumber());
        } catch (InvalidCredentialException | PaymentNotFoundException | ProviderConnectionException $e) {

        }
    }
}