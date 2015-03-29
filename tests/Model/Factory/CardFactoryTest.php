<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Factory\CardFactory;

class CardFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CardFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->SUT = new CardFactory();
    }

    public function testGetName()
    {
        $this->assertEquals('card', $this->SUT->getName());
    }

    public function testCreate()
    {
        $json = [
            'last4'     => '1111',
            'brand'     => 'Visa',
            'exp_month' => 12,
            'exp_year'  => 19,
            'name'      => 'Taro Spike',
        ];

        $card = $this->SUT->create($json);
        $this->assertInstanceOf('Issei\Spike\Model\Card', $card);
        $this->assertEquals('1111', $card->getCardNumberLast4());
        $this->assertEquals('Visa', $card->getBrand());
        $this->assertSame(12, $card->getExpirationMonth());
        $this->assertSame(19, $card->getExpirationYear());
        $this->assertEquals('Taro Spike', $card->getHolderName());
    }
}
