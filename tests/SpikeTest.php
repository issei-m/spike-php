<?php

namespace Issei\Spike\Tests;

use Issei\Spike\ChargeRequest;
use Issei\Spike\Exception\RequestException;
use Issei\Spike\Http\Response;
use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\ObjectList;
use Issei\Spike\Model\Product;
use Issei\Spike\Model\Token;
use Issei\Spike\Spike;
use Issei\Spike\TokenRequest;

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
    private $objectConverter;

    /**
     * @var Spike
     */
    private $SUT;

    protected function setUp()
    {
        $this->httpClient      = $this->getMock('Issei\Spike\Http\ClientInterface');
        $this->objectConverter = $this->getMock('Issei\Spike\Converter\ObjectConverterInterface');

        $this->SUT = new Spike(self::SECRET, $this->httpClient, $this->objectConverter);
    }

    public function testGetToken()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', Spike::ENDPOINT_PREFIX . '/tokens/123', self::SECRET, [])
            ->will($this->returnValue(new Response(200, json_encode(['charge']))));

        $token = new Token('123');
        $this->objectConverter->expects($this->once())->method('convert')->with(['charge'])->will($this->returnValue($token));

        $this->assertSame($token, $this->SUT->getToken('123'));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function getToken_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        try {
            $this->SUT->getToken('');
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    public function testRequestToken()
    {
        $request = $this->createTokenRequest();

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/tokens', self::SECRET, [
                'card[number]' => $request->getCardNumber(),
                'card[exp_month]' => $request->getExpirationMonth(),
                'card[exp_year]' => $request->getExpirationYear(),
                'card[cvc]' => $request->getSecurityCode(),
                'card[name]' => $request->getHolderName(),
                'currency' => $request->getCurrency(),
                'email' => $request->getEmail(),
            ])
            ->will($this->returnValue(new Response(200, json_encode(['token-data']))))
        ;

        $token = new Token('token');
        $this->objectConverter->expects($this->once())->method('convert')->with(['token-data'])->willReturn($token);

        $this->assertSame($token, $this->SUT->requestToken($request));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function requestToken_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        try {
            $this->SUT->requestToken($this->createTokenRequest());
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    public function testGetCharges()
    {
        $response = new Response(200, json_encode([
            'data' => [
                ['charge-a-data'],
                ['charge-b-data'],
            ],
            'has_more' => true,
        ]));

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', Spike::ENDPOINT_PREFIX . '/charges?limit=3', self::SECRET, [])
            ->will($this->returnValue($response));

        $charges = new ObjectList([new Charge('charge-a'), new Charge('charge-b')], true);

        $this->objectConverter
            ->expects($this->once())
            ->method('convert')
            ->with([
                'data' => [
                    ['charge-a-data'],
                    ['charge-b-data'],
                ],
                'has_more' => true,
            ])
            ->willReturn($charges);

        $this->assertSame($charges, $this->SUT->getCharges(3));
    }

    public function testGetChargesWithStartingAfterAndEndingBefore()
    {
        $response = new Response(200, json_encode([
            'data' => [
                ['charge-b-data'],
            ],
            'has_more' => true,
        ]));

        $this->httpClient
            ->expects($this->any())
            ->method('request')
            ->with('GET', Spike::ENDPOINT_PREFIX . '/charges?limit=5&starting_after=charge-a&ending_before=charge-c', self::SECRET, [])
            ->will($this->returnValue($response))
        ;

        $charges = new ObjectList([new Charge('charge-b')], true);
        $this->objectConverter
            ->expects($this->any())
            ->method('convert')->with([
                'data' => [
                    ['charge-b-data'],
                ],
                'has_more' => true,
            ])
            ->willReturn($charges)
        ;

        $this->assertSame($charges, $this->SUT->getCharges(5, new Charge('charge-a'), new Charge('charge-c')));
        $this->assertSame($charges, $this->SUT->getCharges(5, 'charge-a', 'charge-c'), '$startingAfter and $endingBefore are allowed to be a string.');
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
            ->will($this->returnValue(new Response(200, json_encode(['charge']))));

        $charge = new Charge('123');
        $this->objectConverter->expects($this->once())->method('convert')->with(['charge'])->will($this->returnValue($charge));

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
        $request = $this->createChargeRequest();

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/charges', self::SECRET, [
                'card' => $request->getToken()->getId(),
                'amount' => $request->getAmount()->getAmount(),
                'currency' => $request->getAmount()->getCurrency(),
                'capture' => $request->isCapture(),
                'products' => json_encode($request->getProducts()),
            ])
            ->will($this->returnValue(new Response(200, json_encode(['charge-data']))))
        ;

        $charge = new Charge('charge');
        $this->objectConverter->expects($this->once())->method('convert')->with(['charge-data'])->willReturn($charge);

        $this->assertSame($charge, $this->SUT->charge($request));
    }

    /**
     * @test
     */
    public function charge_should_avoid_error_even_if_request_has_not_set_any_value_at_all()
    {
        $request = new ChargeRequest();

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/charges', self::SECRET, [
                'card' => null,
                'amount' => null,
                'currency' => null,
                'capture' => true,
                'products' => json_encode([]),
            ])
            ->willReturn(new Response(200, json_encode(['charge-data'])))
        ;

        $charge = new Charge('charge');
        $this->objectConverter->expects($this->once())->method('convert')->with(['charge-data'])->willReturn($charge);

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
            $this->SUT->charge($this->createChargeRequest());
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    public function testCapture()
    {
        $this->httpClient
            ->expects($this->any())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/charges/charge-a/capture', self::SECRET, [])
            ->will($this->returnValue(new Response(200, json_encode(['charge-a-data']))));

        $charge = new Charge('charge-a');
        $this->objectConverter->expects($this->any())->method('convert')->with(['charge-a-data'])->will($this->returnValue($charge));

        $this->assertSame($charge, $this->SUT->capture(new Charge('charge-a')));
        $this->assertSame($charge, $this->SUT->capture('charge-a'), '$charge is allowed to be a string.');
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\RequestException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage _error_message_
     */
    public function capture_should_throw_Exception_if_api_returned_error()
    {
        $this->expect_that_httpClient_returns_response_which_is_appealing_there_is_error();

        try {
            $this->SUT->capture(new Charge(''));
        } catch (RequestException $e) {
            $this->assertEquals('_error_type_', $e->getType());
            throw $e;
        }
    }

    public function testRefund()
    {
        $this->httpClient
            ->expects($this->any())
            ->method('request')
            ->with('POST', Spike::ENDPOINT_PREFIX . '/charges/charge-a/refund', self::SECRET, [])
            ->will($this->returnValue(new Response(200, json_encode(['charge-a-data']))));

        $charge = new Charge('charge-a');
        $this->objectConverter->expects($this->any())->method('convert')->with(['charge-a-data'])->will($this->returnValue($charge));

        $this->assertSame($charge, $this->SUT->refund(new Charge('charge-a')));
        $this->assertSame($charge, $this->SUT->refund('charge-a'), '$charge is allowed to be a string.');
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

    public function testGetDefaultObjectConverterBuilder()
    {
        $this->assertInstanceOf('Issei\Spike\Converter\RecursiveObjectFactoryConverterBuilder', $this->SUT->getDefaultObjectConverterBuilder());
    }

    /**
     * @return ChargeRequest
     */
    private function createChargeRequest()
    {
        $request = new ChargeRequest();
        $request
            ->setToken(new Token('_card_'))
            ->setAmount(new Money(1000, 'JPY'))
            ->setCapture(false)
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
            );

        return $request;
    }

    /**
     * @return TokenRequest
     */
    private function createTokenRequest()
    {
        $request = new TokenRequest();
        $request
            ->setCardNumber('4444333322221111')
            ->setExpirationMonth(12)
            ->setExpirationYear(19)
            ->setHolderName('Taro Spike')
            ->setSecurityCode(123)
            ->setCurrency('JPY')
            ->setEmail('test@example.jp')
        ;

        return $request;
    }

    private function expect_that_httpClient_returns_response_which_is_appealing_there_is_error()
    {
        $response = new Response(400, json_encode([
            'error' => [
                'type' => '_error_type_',
                'message' => '_error_message_',
            ],
        ]));

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($response));
    }
}
