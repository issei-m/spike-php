<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonSerialize()
    {
        $product = new Product('product');
        $product
            ->setTitle('title')
            ->setDescription('description')
            ->setPrice(new Money(100, 'JPY'))
            ->setLanguage('JP')
            ->setCount(1)
            ->setStock(9)
        ;
        $expectedJson = json_encode([
            'id'          => 'product',
            'title'       => 'title',
            'description' => 'description',
            'language'    => 'JP',
            'price'       => 100,
            'currency'    => 'JPY',
            'count'       => 1,
            'stock'       => 9,
        ]);
        $this->assertEquals($expectedJson, json_encode($product));

        $product = new Product('product');
        $expectedJson = json_encode([
            'id'          => 'product',
            'title'       => null,
            'description' => null,
            'language'    => null,
            'price'       => null,
            'currency'    => null,
            'count'       => null,
            'stock'       => null,
        ]);
        $this->assertEquals($expectedJson, json_encode($product), 'Should be serializable as json even if has not set any value at all');
    }

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
