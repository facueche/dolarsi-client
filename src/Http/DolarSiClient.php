<?php

namespace DigitalRevolution\DolarSi\Http;

class DolarSiClient
{
    const DOLARSI_API_URL = 'https://www.dolarsi.com/api/api.php?type=valoresprincipales';

    private $guzzle;

    public function __construct(\GuzzleHttp\Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public static function getInstance(\GuzzleHttp\Client $guzzle): DolarSiClient
    {
        return new DolarSiClient($guzzle);
    }

    public function getDollarPrice(): float
    {
        $response = $this->guzzle->get(self::DOLARSI_API_URL);
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
