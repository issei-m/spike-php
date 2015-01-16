<?php

namespace Issei\Spike\Tests;

use Issei\Spike\ChargeRequest;
use Issei\Spike\Exception\RequestException;
use Issei\Spike\Http\Response;
use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;
use Issei\Spike\Spike;

class SpikeTest extends \PHPUnit_Framework_TestCase
{
    const SECRET = '_SECRET_';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $chargeFactory;

    /**
     * @var Spike
     */
    private $SUT;

    protected function setUp()
    {
        $this->httpClient    = $this->getMock('Issei\Spike\Http\ClientInterface');
        $this->chargeFactory = $this->getMockBuilder('Issei\Spike\Model\Factory\ChargeFactory')->disableOriginalConstructor()->getMock();

        $this->SUT = new Spike(self::SECRET, $this->httpClient, $this->chargeFactory);
    }

    /**
     * @return ChargeRequest
     */
    private function createCharge()
    {
        $request = new ChargeRequest();
        $request
            ->setCard('_card_')
            ->setAmount(new Money(1000, 'JPY'))
            ->addProduct(
                (new Product('product-a'))
                    ->setTitle('Product.A')
                    ->setDescription('This is Product.A')
                    ->setPrice(new Money(500, 'JPY'))
                    ->setLanguage('JP')
                    ->setCount(1)
                    ->setStock(10)
            )
            ->addProduct(
                (new Product('product-b'))
                    ->setTitle('Product.B')
                    ->setDescription('This is Product.B')
                    ->setPrice(new Money(500, 'JPY'))
                    ->setLanguage('JP')
                    ->setCount(3)
                    ->setStock(5)
            )
        ;

        return $request;
    }

    public function testGetCharges()
    {
        $response = new Response(200, json_encode([
            'data' => [
                ['charge-a-data'],
                ['charge-b-data'],
            ],
        ]));

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', Spike::ENDPOINT_PREFIX . '/charges?limit=3', self::SECRET, [])
            ->will($this->returnValue($response))
        ;

        $chargeA = new Charge('charge-a');
        $chargeB = new Charge('charge-b');
        $this->chargeFactory->expects($this->at(0))->method('create')->with(['charge-a-data'])->will($this->returnValue($chargeA));
        $this->chargeFactory->expects($this->at(1))->method('create')->with(['charge-b-data'])->will($this->returnValue($chargeB));

        $this->assertSame([$chargeA, $chargeB], $this->SUT->getCharges(3));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function getCharges_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        $this->SUT->getCharges(3);
    }

    public function testGetCharge()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', Spike::ENDPOINT_PREFIX . '/charges/123', self::SECRET, [])
            ->will($this->returnValue(new Response(200, json_encode(['charge']))))
        ;

        $charge = new Charge('123');
        $this->chargeFactory->expects($this->once())->method('create')->with(['charge'])->will($this->returnValue($charge));

        $this->assertSame($charge, $this->SUT->getCharge('123'));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function getCharge_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        try {
            $this->SUT->getCharge('');
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    public function testCharge()
    {
        $request = $this->createCharge();

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/charges', self::SECRET, [
                'card'     => $request->getCard(),
                'amount'   => $request->getAmount()->getAmount(),
                'currency' => $request->getAmount()->getCurrency(),
                'products' => json_encode($request->getProducts()),
            ])
            ->will($this->returnValue(new Response(200, json_encode(['charge-c-data']))))
        ;

        $charge = new Charge('charge-c');
        $this->chargeFactory->expects($this->once())->method('create')->with(['charge-c-data'])->will($this->returnValue($charge));

        $this->assertSame($charge, $this->SUT->charge($request));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function charge_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        try {
            $this->SUT->charge($this->createCharge());
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    public function testRefund()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/charges/charge-a/refund', self::SECRET, [])
            ->will($this->returnValue(new Response(200, json_encode(['charge-a-data']))))
        ;

        $charge = new Charge('charge-a');
        $this->chargeFactory->expects($this->once())->method('create')->with(['charge-a-data'])->will($this->returnValue($charge));

        $this->assertSame($charge, $this->SUT->refund(new Charge('charge-a')));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function refund_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        try {
            $this->SUT->refund(new Charge(''));
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    private function expect_that_httpClient_returns_response_which_is_appealing_there_is_error()
    {
        $response = new Response(400, json_encode([
            'error' => [
                'type'    => '_error_type_',
                'message' => '_error_message_',
            ],
        ]));

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($response))
        ;
    }
}
