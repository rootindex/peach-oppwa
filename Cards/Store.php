<?php
/**
 * Copyright (c) 2016. Francois Raubenheimer
 */

namespace Peach\Oppwa\Cards;

use GuzzleHttp\Exception\RequestException;
use Peach\Oppwa\Client;
use Peach\Oppwa\ClientInterface;

/**
 * Class Store
 * @package Peach\Oppwa\Cards
 */
class Store extends AbstractCard implements ClientInterface
{
    /**
     * Oppwa client object.
     *
     * @var Client
     */
    private $client;

    /**
     * Store constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    /**
     * Process store card procedure.
     * @return \stdClass
     * @throws \Exception
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
        return $this->client->getApiUri() . '/registrations';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'authentication.userId' => $this->client->getConfig()->getUserId(),
            'authentication.password' => $this->client->getConfig()->getPassword(),
            'authentication.entityId' => $this->client->getConfig()->getEntityId(),
            'paymentBrand' => $this->getCardBrand(),
            'card.number' => $this->getCardNumber(),
            'card.holder' => $this->getCardHolder(),
            'card.expiryMonth' => $this->getCardExpiryMonth(),
            'card.expiryYear' => $this->getCardExpiryYear(),
            'card.cvv' => $this->getCardCvv()
        ];
    }
}
