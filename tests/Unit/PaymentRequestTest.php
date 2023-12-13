<?php

namespace YOoSlim\TestK\Tests\Unit;

use PHPUnit\Framework\TestCase;
use YOoSlim\TestK\Payment\Requests\RegisterRequest;
use YOoSlim\TestK\Utils\CreditCard;
use YOoSlim\TestK\Utils\CurrencyEnum;

class PaymentRequestTest extends TestCase
{
    /**
     * Test that signature didnt change
     *
     * @return void
     */
    public function test_that_payment_request_class_signature_didnt_change()
    {
        new RegisterRequest(
            2542.00,
            CurrencyEnum::EURO,
            new CreditCard('1234567891234569'),
        );

        $this->assertTrue(true);
    }
}