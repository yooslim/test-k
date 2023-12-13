<?php

namespace Stripe\Core;

use Illuminate\Support\Str;
use Stripe\Exception\StripeConnectionException;
use Stripe\Exception\StripeInvalidCredentialException;
use Stripe\Exception\StripePaymentProcessException;
use Stripe\Exception\StripeResourceNotFoundException;

trait StripeProviderTrait
{
    /**
     * Register a new payment instance into stripe
     * 
     * @param  float $amount
     * @param  string $currency
     * @param  string $cardNumber
     * @return array
     * @throws StripeConnectionException | StripeInvalidCredentialException | StripePaymentProcessException
     */
    public function stripePaymentProcess(float $amount, string $currency, string $cardNumber): array
    {
        // API call to stripe WS
        
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
     * @throws StripeConnectionException | StripeInvalidCredentialException | StripeResourceNotFoundException
     */
    public function stripeGetPayment(string $id): array
    {
        return [
            'id' => $id,
            'status' => 'pending',
            'redirect' => '',
            'currency' => 'usd',
            'card' => '4242424242424242',
            'amount' => 150.00
            // More
        ];
    }
}