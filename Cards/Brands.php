<?php
/**
 * Copyright (c) 2016. Francois Raubenheimer
 */

namespace Peach\Oppwa\Cards;

/**
 * Class Brands
 * @package Peach\Oppwa\Cards
 */
class Brands
{
    const VISA = 'VISA';
    const MASTERCARD = 'MASTER';
    const AMEX = 'AMEX';
    const DINERSCLUB = 'DINERS';

    /**
     * Map from OPPWA to Validator.
     *
     * @param $brand
     * @return string
     */
    public static function mapFromOppwaToValidator($brand)
    {
        if ($brand === self::VISA) {
            return 'visa';
        }
        if ($brand === self::MASTERCARD) {
            return 'mastercard';
        }
        if ($brand === self::AMEX) {
            return 'amex';
        }
        if ($brand === self::DINERSCLUB) {
            return 'dinersclub';
        }

        return 'other';
    }
}
