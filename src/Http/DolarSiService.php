<?php

namespace DigitalRevolution\DolarSi\Http;

use GuzzleHttp\Client;

class DolarSiService
{
    /** @var Client */
    public $client;

    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function getDollarPrice(): float
    {
        $response = $this->client->get('api.php?type=valoresprincipales');
        return floatval(str_replace(',', '.', json_decode($response->getBody()->getContents(), true)[0]['casa']['venta']));
    }

    public function dollar2ArgentinianPeso(float $dollarValue): float
    {
        return $this->getDollarPrice() * $dollarValue;
    }

    public function argentinianPeso2Dollar(float $pesoValue): float
    {
        return $pesoValue / $this->getDollarPrice();
    }
}
