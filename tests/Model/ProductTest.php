<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $product = new Product('product');

        $product
            ->setTitle('title')
            ->setDescription('description')
            ->setLanguage('JP')
            ->setCount(1)
            ->setStock(9)
        ;
        $this->assertEquals('product', $product->getId());
        $this->assertEquals('title', $product->getTitle());
        $this->assertEquals('description', $product->getDescription());
        $this->assertEquals('JP', $product->getLanguage());
        $this->assertEquals(1, $product->getCount());
        $this->assertEquals(9, $product->getStock());
    }

    public function testPriceAccessors()
    {
        $product = new Product('product');

        $product->setPrice(new Money(1000.0, 'JPY'));
        $this->assertEquals(new Money(1000.0, 'JPY'), $product->getPrice());

        $product->setPrice(100.50, 'USD');
        $this->assertEquals(new Money(100.50, 'USD'), $product->getPrice());
    }
}
