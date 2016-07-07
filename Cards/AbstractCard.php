<?php
/**
 * Copyright (c) 2016. Francois Raubenheimer
 */

namespace Peach\Oppwa\Cards;

/**
 * Class AbstractCard
 * @package Peach\Oppwa\Cards
 */
abstract class AbstractCard
{
    const EXCEPTION_CARD_INVALID = 400;
    const EXCEPTION_CARD_BRAND_INVALID = 401;
    const EXCEPTION_CARD_NUMBER_INVALID = 402;
    const EXCEPTION_CARD_HOLDER_INVALID = 403;
    const EXCEPTION_CARD_EXPIRE_YEAR_INVALID = 404;
    const EXCEPTION_CARD_EXPIRE_MONTH_INVALID = 405;
    const EXCEPTION_CARD_CVV_INVALID = 406;

    private $cardBrand;
    private $cardNumber;
    private $cardHolder;
    private $cardExpiryMonth;
    private $cardExpiryYear;
    private $cardCvv;

    /**
     * AbstractCard constructor.
     */
    public function __construct()
    {
        
    }

    /**
     * Check if card is valid
     *
     * @throws \Exception
     */
    public function isCardDetailsValid()
    {
        if (empty($this->cardBrand)) {
            throw new \Exception("Card Brand not valid", self::EXCEPTION_CARD_BRAND_INVALID);
        }
        if (empty($this->cardHolder)) {
            throw new \Exception("Card Holder not valid", self::EXCEPTION_CARD_HOLDER_INVALID);
        }
        if (empty($this->cardCvv)) {
            throw new \Exception("Card CVV not valid", self::EXCEPTION_CARD_CVV_INVALID);
        }
        if (empty($this->cardExpiryMonth)) {
            throw new \Exception("Card Expiry month not valid", self::EXCEPTION_CARD_EXPIRE_MONTH_INVALID);
        }
        if (empty($this->cardExpiryYear)) {
            throw new \Exception("Card Expiry year not valid", self::EXCEPTION_CARD_EXPIRE_YEAR_INVALID);
        }
        if (empty($this->cardHolder)) {
            throw new \Exception("Card holder not valid", self::EXCEPTION_CARD_HOLDER_INVALID);
        }
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
