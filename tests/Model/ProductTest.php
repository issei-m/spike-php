<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $product = new Product('Product.id');
        $product
            ->setTitle('Product.title')
            ->setDescription('Product.description')
            ->setCurrency('JPY')
            ->setPrice(1000.0)
            ->setLanguage('JP')
            ->setCount(1)
            ->setStock(9)
        ;

        $this->assertEquals('Product.id', $product->getId());
        $this->assertEquals('Product.title', $product->getTitle());
        $this->assertEquals('Product.description', $product->getDescription());
        $this->assertEquals('JPY', $product->getCurrency());
        $this->assertSame(1000.0, $product->getPrice());
        $this->assertEquals('JP', $product->getLanguage());
        $this->assertEquals(1, $product->getCount());
        $this->assertEquals(9, $product->getStock());
    }
}
