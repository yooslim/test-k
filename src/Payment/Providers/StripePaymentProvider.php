<?php

namespace YOoSlim\TestK\Payment\Providers;

use Stripe\Core\StripeProviderTrait;
use Stripe\Exception\StripeConnectionException;
use Stripe\Exception\StripeInvalidCredentialException;
use Stripe\Exception\StripePaymentProcessException;
use Stripe\Exception\StripeResourceNotFoundException;
use YOoSlim\TestK\Contracts\PaymentProviderInterface;
use YOoSlim\TestK\Exceptions\InvalidCredentialException;
use YOoSlim\TestK\Exceptions\PaymentNotFoundException;
use YOoSlim\TestK\Exceptions\PaymentProcessException;
use YOoSlim\TestK\Exceptions\ProviderConnectionException;
use YOoSlim\TestK\Payment\Responses\PaymentDetails;
use YOoSlim\TestK\Payment\Requests\DetailsRequest;
use YOoSlim\TestK\Payment\Requests\RegisterRequest;
use YOoSlim\TestK\Utils\CreditCard;
use YOoSlim\TestK\Utils\CurrencyEnum;

class StripePaymentProvider implements PaymentProviderInterface
{
    use StripeProviderTrait;

    /**
     * Register a payment within a defined payment provider
     * 
     * @param  RegisterRequest $request
     * @return PaymentDetails
     * @throws ProviderConnectionException | InvalidCredentialException | PaymentProcessException
     */
    public function registerPayment(RegisterRequest $request): PaymentDetails
    {
        try {
            $instance = $this->stripePaymentProcess(
                $request->amount,
                $request->currency->value,
                $request->card->getCardNumber()
            );

            return new PaymentDetails(
                $request,
                $instance['id'],
                $instance['status'],
                $instance['redirect'],
            );
        } catch (StripeConnectionException $e) {
            throw new ProviderConnectionException($e);
        } catch (StripeInvalidCredentialException $e) {
            throw new InvalidCredentialException($e);
        } catch (StripePaymentProcessException $e) {
            throw new PaymentProcessException($e);
        }
    }

    /**
     * Retrieve a payment details within a defined payment provider
     * 
     * @param  DetailsRequest $request
     * @return PaymentDetails
     * @throws ProviderConnectionException | InvalidCredentialException | PaymentNotFoundException
     */
    public function getPaymentDetails(DetailsRequest $request): PaymentDetails
    {
        try {
            $instance = $this->stripeGetPayment($request->id);

            return new PaymentDetails(
                new RegisterRequest(
                    $instance['amount'],
                    CurrencyEnum::getByValue($instance['currency']),
                    new CreditCard($instance['card'])
                ),
                $instance['id'],
                $instance['status'],
                $instance['redirect'],
            );
        } catch (StripeConnectionException $e) {
            throw new ProviderConnectionException($e);
        } catch (StripeInvalidCredentialException $e) {
            throw new InvalidCredentialException($e);
        } catch (StripeResourceNotFoundException $e) {
            throw new PaymentNotFoundException($e);
        }
    }
}