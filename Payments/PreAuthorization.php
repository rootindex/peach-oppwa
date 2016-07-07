<?php
/**
 * Copyright (c) 2016. Francois Raubenheimer
 */

namespace Peach\Oppwa\Payments;

use GuzzleHttp\Exception\RequestException;
use Peach\Oppwa\Cards\AbstractCard;
use Peach\Oppwa\Client;
use Peach\Oppwa\ClientInterface;

/**
 * Class PreAuthorization
 * @package Peach\Oppwa\Payments
 */
class PreAuthorization extends AbstractCard implements ClientInterface
{
    private $client;
    private $amount;
    private $currency = 'ZAR';
    private $paymentType = 'PA';
    private $createRegistration = false;

    /**
     * PreAuthorization constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    /**
     * @return object
     */
    public function process()
    {
        try {
            $this->isCardDetailsValid();
        } catch (\Exception $e) {
            return (object)['result' => ['code' => $e->getCode(), 'message' => $e->getMessage()]];
        }
        
        $client = $this->client->getClient();

        try {
            $response = $client->post($this->buildUrl(), [
                'form_params' => $this->getParams()
            ]);
            return \GuzzleHttp\json_decode((string)$response->getBody());
        } catch (RequestException $e) {
            return \GuzzleHttp\json_decode($e->getResponse()->getBody());
        }

    }

    /**
     * @return string
     */
    public function buildUrl()
    {
        return $this->client->getApiUri() . '/payments';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [
            'authentication.userId' => $this->client->getConfig()->getUserId(),
            'authentication.password' => $this->client->getConfig()->getPassword(),
            'authentication.entityId' => $this->client->getConfig()->getEntityId(),
            'paymentBrand' => $this->getCardBrand(),
            'card.number' => $this->getCardNumber(),
            'card.holder' => $this->getCardHolder(),
            'card.expiryMonth' => $this->getCardExpiryMonth(),
            'card.expiryYear' => $this->getCardExpiryYear(),
            'card.cvv' => $this->getCardCvv(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'paymentType' => $this->getPaymentType()
        ];

        if ($this->isCreateRegistration()) {
            $params['createRegistration'] = true;
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @deprecated 0.0.1
     * @return $this
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->currency);
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        // oppwa format
        return number_format($this->amount, 2, '.', '');
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCreateRegistration()
    {
        return $this->createRegistration;
    }

    /**
     * @param boolean $createRegistration
     * @return $this
     */
    public function setCreateRegistration($createRegistration)
    {
        $this->createRegistration = $createRegistration;
        return $this;
    }
}
