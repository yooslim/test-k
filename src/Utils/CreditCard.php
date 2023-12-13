<?php

namespace YOoSlim\TestK\Utils;

class CreditCard
{
    /**
     * Card number
     * 
     * @var string
     */
    private string $number;

    /**
     * Constructor
     */
    public function __construct(
        string $number
    ) {
        // More validations here
        if (strlen($number) !== 16) {
            throw new \Exception('Wrong card number.');
        }

        $this->number = $number;
    }

    /**
     * Get card number
     * 
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->number;
    }
    
    /**
     * Get masked card number
     * 
     * @return string
     */
    public function getMaskedCardNumber(): string
    {
        return substr($this->number, 0, 4) . 
            str_repeat('*', strlen($this->number) - 8) . 
            substr($this->number, -4);
    }
}