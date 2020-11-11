<?php

namespace DigitalRevolution\DolarSi\Tests;

use DigitalRevolution\DolarSi\Http\DolarSiService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class DolarSiRequestTest extends \PHPUnit\Framework\TestCase
{
    /** @var DolarSiService */
    private $dollarSiService;

    protected function setUp(): void {
        parent::setUp();
        $this->dollarSiService = app(DolarSiService::class);
        $this->dollarSiService->setClient($this->getHandlerStackClient());
    }

    public function testArgentianDollarPriceRetrievement()
    {
        $response = $this->dollarSiService->getDollarPrice();
        $this->assertEquals($response, 20);
    }

    public function testDollar2ArgentinianPeso()
    {
        $response = $this->dollarSiService->dollar2ArgentinianPeso(2);
        $this->assertEquals($response, 40);
    }

    public function testArgentinianPeso2Dollar()
    {
        $response = $this->dollarSiService->argentinianPeso2Dollar(40);
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

    private function getHandlerStackClient(): Client
    {
        return new Client([
            'base_uri' => 'http://127.0.0.1/',
            'handler' => HandlerStack::create($this->successResponseMock())
        ]);
    }
}
