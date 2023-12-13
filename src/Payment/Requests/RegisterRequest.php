<?php

namespace YOoSlim\TestK\Payment\Requests;

use YOoSlim\TestK\Utils\CreditCard;
use YOoSlim\TestK\Utils\CurrencyEnum;

class RegisterRequest
{
    /**
     * Constructor
     * 
     * @param  float $amount
     * @param  CurrencyEnum $currency
     * @param  CreditCard $card
     */
    public function __construct(
        public float $amount,
        public CurrencyEnum $currency,
        public CreditCard $card
    ) {
        //
    }
}