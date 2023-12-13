<?php

namespace PayPal\Core;

use Illuminate\Support\Str;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Exception\PayPalInvalidCredentialException;
use PayPal\Exception\PayPalPaymentProcessException;
use PayPal\Exception\PayPalResourceNotFoundException;

trait PayPalProviderTrait
{
    /**
     * Register a new payment instance into paypal
     * 
     * @param  float $amount
     * @param  string $currency
     * @param  string $cardNumber
     * @return array
     * @throws PayPalConnectionException | PayPalInvalidCredentialException | PayPalPaymentProcessException
     */
    public function paypalPaymentProcess(float $amount, string $currency, string $cardNumber): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'status' => 'pending',
            'redirect' => '',
            // More
        ];
    }

    /**
     * Retrieve a payment instance details
     * 
     * @param  string $id
     * @return array
     * @throws PayPalConnectionException | PayPalInvalidCredentialException | PayPalResourceNotFoundException
     */
    public function paypalGetPayment(string $id): array
    {
        if ($id !== 'PAYPAL98765ZYX') {
            throw new PayPalResourceNotFoundException();
        }

        return [
            'id' => $id,
            'status' => 'pending',
            'redirect' => '',
            'currency' => 'eur',
            'card' => '4000056655665556',
            'amount' => 200.00
            // More
        ];
    }
}