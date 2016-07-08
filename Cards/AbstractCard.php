<?php
/**
 * Copyright (c) 2016. Francois Raubenheimer
 */

namespace Peach\Oppwa\Cards;

use Inacho\CreditCard;

/**
 * Class AbstractCard
 * @package Peach\Oppwa\Cards
 */
abstract class AbstractCard
{
    const EXCEPTION_CARD_INVALID = 400;
    const EXCEPTION_CARD_VAR_EMPTY = 400;
    const EXCEPTION_CARD_CVV_INVALID = 400;

    private $cardBrand;
    private $cardNumber;
    private $cardHolder;
    private $cardExpiryMonth;
    private $cardExpiryYear;
    private $cardCvv;

    /**
     * Check if card is valid
     *
     * @throws \Exception
     */
    public function isCardDetailsValid()
    {
        $cardVariables = ['cardBrand', 'cardNumber', 'cardHolder', 'cardExpiryMonth', 'cardExpiryYear', 'cardCvv'];

        // check for any empty variables
        foreach ($cardVariables as $cardVariable) {
            if (empty($this->$cardVariable)) {
                throw new \Exception(sprintf("Card variable empty %s", $cardVariable), self::EXCEPTION_CARD_VAR_EMPTY);
            }
        }
        // validate card
        if (!$this->validateCard()) {
            throw new \Exception("Card not valid", self::EXCEPTION_CARD_INVALID);
        }
        // validate cvv
        if (!$this->validateCardCvv()) {
            throw new \Exception("Card CVV not valid", self::EXCEPTION_CARD_CVV_INVALID);
        }
        // validate card date
        if (!$this->validateCardDate()) {
            throw new \Exception("Card date not valid", self::EXCEPTION_CARD_CVV_INVALID);
        }
    }


    /**
     * Validate card including luhn.
     *
     * @return bool
     * @throws \Exception
     */
    public function validateCard()
    {
        $validator = CreditCard::validCreditCard(
            $this->cardNumber,
            Brands::mapFromOppwaToValidator($this->cardBrand)
        );

        if (!array_key_exists('valid', $validator)) {
            return false;
        }

        return (boolean)$validator['valid'];
    }

    /**
     * @return bool
     */
    public function validateCardCvv()
    {
        return CreditCard::validCvc($this->cardCvv, Brands::mapFromOppwaToValidator($this->cardBrand));
    }

    public function validateCardDate()
    {
        return CreditCard::validDate($this->cardExpiryYear, $this->cardExpiryMonth);
    }
    
    /**
     * @return string
     */
    public function getCardBrand()
    {
        return $this->cardBrand;
    }

    /**
     * @param string $cardBrand
     * @return $this
     */
    public function setCardBrand($cardBrand)
    {
        $this->cardBrand = $cardBrand;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return $this
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolder()
    {
        return $this->cardHolder;
    }

    /**
     * @param string $cardHolder
     * @return $this
     */
    public function setCardHolder($cardHolder)
    {
        $this->cardHolder = $cardHolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiryMonth()
    {
        return $this->cardExpiryMonth;
    }

    /**
     * @param string $cardExpiryMonth
     * @return $this
     */
    public function setCardExpiryMonth($cardExpiryMonth)
    {
        $this->cardExpiryMonth = $cardExpiryMonth;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiryYear()
    {
        return $this->cardExpiryYear;
    }

    /**
     * @param string $cardExpiryYear
     * @return $this
     */
    public function setCardExpiryYear($cardExpiryYear)
    {
        $this->cardExpiryYear = $cardExpiryYear;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardCvv()
    {
        return $this->cardCvv;
    }

    /**
     * @param string $cardCvv
     * @return $this
     */
    public function setCardCvv($cardCvv)
    {
        $this->cardCvv = $cardCvv;
        return $this;
    }
}
