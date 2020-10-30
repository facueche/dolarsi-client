<?php

namespace DigitalRevolution\DolarSi\Tests;

use DigitalRevolution\DolarSi\Http\DolarSiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class DolarSiRequestTest extends \PHPUnit\Framework\TestCase
{
    private $dollarSiClient;

    protected function setUp(): void {
        parent::setUp();
        $this->dollarSiClient = new DolarSiClient($this->getHandlerStackClient($this->successResponseMock()));
    }

    public function testArgentianDollarPriceRetrievement()
    {
        $response = $this->dollarSiClient->getDollarPrice();
        $this->assertEquals($response, 20);
    }

    public function testDollar2ArgentinianPeso()
    {
        $response = $this->dollarSiClient->dollar2ArgentinianPeso(2);
        $this->assertEquals($response, 40);
    }

    public function testArgentinianPeso2Dollar()
    {
        $response = $this->dollarSiClient->argentinianPeso2Dollar(40);
        $this->assertEquals($response, 2);
    }

    private function successResponseMock(): MockHandler
    {
        return new MockHandler([
            new Response(200, [], json_encode([
                [
                    'casa' => [
                        "compra" => "10",
                        "venta" => "20",
                        "agencia" => "349",
                        "nombre" => "Dolar Oficial",
                        "variacion" => "0,010",
                        "ventaCero" => "TRUE",
                        "decimales" => "3",
                    ],
                ]
            ]))
        ]);
    }

    private function getHandlerStackClient(MockHandler $mock): Client
    {
        return new Client(['handler' => HandlerStack::create($mock)]);
    }
}
