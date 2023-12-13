<?php

namespace YOoSlim\TestK\Utils;

enum CurrencyEnum: string
{
    case EURO = 'eur';
    case DOLLAR = 'usd';

    /**
     * Get enum using value
     * 
     * @return self
     */
    public static function getByValue(string $value): self {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        throw new \Exception('Currency undefined.');
    }
}