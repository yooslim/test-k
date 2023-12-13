<?php

namespace YOoSlim\TestK\Payment\Services;

use ReflectionClass;
use YOoSlim\TestK\Contracts\DefaultPaymentProviderInterface;
use YOoSlim\TestK\Contracts\PaymentProviderInterface;
use YOoSlim\TestK\Exceptions\UndefinedPaymentProviderException;
use YOoSlim\TestK\Exceptions\UndefinedPaymentRequestException;
use YOoSlim\TestK\Exceptions\WrongPaymentRequestException;
use YOoSlim\TestK\Payment\Responses\PaymentDetails;
use YOoSlim\TestK\Payment\Requests\DetailsRequest;
use YOoSlim\TestK\Payment\Requests\RegisterRequest;

class PaymentService
{
    /**
     * Current payment provider
     * 
     * @var ?PaymentProviderInterface
     */
    private ?PaymentProviderInterface $provider = null;

    /**
     * Current payment request
     * 
     * @var RegisterRequest | DetailsRequest | null
     */
    private RegisterRequest | DetailsRequest | null $request = null;

    /**
     * Sets the default payment provider as the current payment provider
     * 
     * @return self
     */
    public function useDefaultProvider(): self
    {
        $this->provider = app()->make(DefaultPaymentProviderInterface::class);

        return $this;
    }

    /**
     * Sets the selected payment provider as the current payment provider
     * 
     * @param  PaymentProviderInterface $provider
     * @return self
     */
    public function useProvider(PaymentProviderInterface | string $provider): self
    {
        if (is_a($provider, PaymentProviderInterface::class)) {
            $this->provider = $provider;

            return $this;
        }

        return $this->useProvider(
            (new ReflectionClass($provider))->newInstance()
        );
    }

    /**
     * Sets the payment request
     * 
     * @param  RegisterRequest | DetailsRequest $request
     * @return self
     */
    public function setRequest(RegisterRequest | DetailsRequest  $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Registers the payment request into the payment provider sdk
     * 
     * @return PaymentDetails
     * @throws UndefinedPaymentProviderException | UndefinedPaymentRequestException
     */
    public function register(): PaymentDetails
    {
        if (is_null($this->provider)) {
            if (config('testk.use_default') === true) {
                $this->useDefaultProvider();
            } else {
                throw new UndefinedPaymentProviderException();    
            }
        }

        if (is_null($this->request)) {
            throw new UndefinedPaymentRequestException();
        } elseif (!is_a($this->request, RegisterRequest::class)) {
            throw new WrongPaymentRequestException();
        }

        return $this->provider->registerPayment($this->request);
    }

    /**
     * Registers the payment request into the payment provider sdk
     * 
     * @return PaymentDetails
     * @throws UndefinedPaymentProviderException | UndefinedPaymentRequestException
     */
    public function get(): PaymentDetails
    {
        if (is_null($this->provider)) {
            if (config('testk.use_default') === true) {
                $this->useDefaultProvider();
            } else {
                throw new UndefinedPaymentProviderException();    
            }
        }

        if (is_null($this->request)) {
            throw new UndefinedPaymentRequestException();
        } elseif (!is_a($this->request, DetailsRequest::class)) {
            throw new WrongPaymentRequestException();
        }

        return $this->provider->getPaymentDetails($this->request);
    }
}
