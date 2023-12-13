<?php

namespace YOoSlim\TestK\Tests\Unit;

use PHPUnit\Framework\TestCase;
use YOoSlim\TestK\Utils\CreditCard;

class CreditCardTest extends TestCase
{
    /**
     * Test credit card number validation
     *
     * @return void
     */
    public function test_that_card_validation_fails_when_incorrect_number_is_provided()
    {
        $wrong_entries = [
            '1',
            '',
            '555555555555555555555555555555'
        ];

        $this->expectException('Exception');

        foreach ($wrong_entries as $entry) {
            new CreditCard($entry); 
        }
    }

    /**
     * Test credit card number validation
     *
     * @return void
     */
    public function test_that_card_validation_success_when_correct_number_is_provided()
    {
        $wrong_entries = [
            '1234567891234567',
            '9876543216549878',
            '1478523698521479'
        ];

        foreach ($wrong_entries as $entry) {
            new CreditCard($entry); 
        }

        $this->assertTrue(true);
    }

    /**
     * Test that credit card number is correctly masked
     *
     * @return void
     */
    public function test_that_at_least_6_digits_are_masked_when_showing_card_number()
    {
        $card = new CreditCard('1234567891234569');

        $numberOfStars = \substr_count($card->getMaskedCardNumber(), '*');

        $this->assertGreaterThanOrEqual(6, $numberOfStars);
    }
}