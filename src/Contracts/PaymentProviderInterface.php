<?php

namespace YOoSlim\TestK\Contracts;

use YOoSlim\TestK\Payment\Responses\PaymentDetails;
use YOoSlim\TestK\Exceptions\ProviderConnectionException;
use YOoSlim\TestK\Exceptions\InvalidCredentialException;
use YOoSlim\TestK\Exceptions\PaymentProcessException;
use YOoSlim\TestK\Exceptions\PaymentNotFoundException;
use YOoSlim\TestK\Payment\Requests\DetailsRequest;
use YOoSlim\TestK\Payment\Requests\RegisterRequest;

interface PaymentProviderInterface
{
    /**
     * Register a payment within a defined payment provider
     * 
     * @param  RegisterRequest $request
     * @return PaymentDetails
     * @throws ProviderConnectionException | InvalidCredentialException | PaymentProcessException
     */
    public function registerPayment(RegisterRequest $request): PaymentDetails;

    /**
     * Retrieve a payment details within a defined payment provider
     * 
     * @param  DetailsRequest $request
     * @return PaymentDetails
     * @throws ProviderConnectionException | InvalidCredentialException | PaymentNotFoundException
     */
    public function getPaymentDetails(DetailsRequest $request): PaymentDetails;
}