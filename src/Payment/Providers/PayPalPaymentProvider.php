<?php

namespace YOoSlim\TestK\Payment\Providers;

use PayPal\Core\PayPalProviderTrait;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Exception\PayPalInvalidCredentialException;
use PayPal\Exception\PayPalPaymentProcessException;
use PayPal\Exception\PayPalResourceNotFoundException;
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

class PayPalPaymentProvider implements PaymentProviderInterface
{
    use PayPalProviderTrait;

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
            $instance = $this->paypalPaymentProcess(
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
        } catch (PayPalConnectionException $e) {
            throw new ProviderConnectionException($e);
        } catch (PayPalInvalidCredentialException $e) {
            throw new InvalidCredentialException($e);
        } catch (PayPalPaymentProcessException $e) {
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
            $instance = $this->paypalGetPayment($request->id);

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
        } catch (PayPalConnectionException $e) {
            throw new ProviderConnectionException($e);
        } catch (PayPalInvalidCredentialException $e) {
            throw new InvalidCredentialException($e);
        } catch (PayPalPaymentProcessException $e) {
            throw new PaymentProcessException($e);
        } catch (PayPalResourceNotFoundException $e) {
            throw new PaymentNotFoundException($e);
        }
    }
}