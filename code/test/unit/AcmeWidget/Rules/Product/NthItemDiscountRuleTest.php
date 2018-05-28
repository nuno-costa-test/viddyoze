<?php
use PHPUnit\Framework\TestCase;
use AcmeWidget\Rules\Product\NthItemDiscount;
use AcmeWidget\Product\GenericProduct;

class NthItemDiscountTest extends TestCase
{
    private $rule;

    public function setUp()
    {
        $this->rule = new NthItemDiscount('rule', 'test', GenericProduct::class);
    }

    public function testSetGETProdcutClassFQCN()
    {
        $this->rule->setProdcutClassFQCN('asd');
        $this->assertEquals($this->rule->getProdcutClassFQCN(), 'asd');
    }

    public function testSetGetName()
    {
        $this->rule->setName('foo');
        $this->assertEquals($this->rule->getName(), 'foo');
    }

    public function testSetGetCode()
    {
        $this->rule->setCode('foo');
        $this->assertEquals($this->rule->getCode(), 'foo');
    }

    public function testSetGetItemQuantity()
    {
        $this->rule->setItemQuantity(3);
        $this->assertEquals($this->rule->getItemQuantity(), 3);
    }

    public function testSetGetDiscount()
    {
        $this->rule->setDiscount(.5);
        $this->assertEquals($this->rule->getDiscount(), .5);
    }

    public function testGetSetProduct()
    {
        $product = new GenericProduct();
        $this->rule->setProduct($product);
        $this->assertSame($this->rule->getProduct(), $product);
    }

    public function testCalculate()
    {
        $this->rule->setItemQuantity(2);
        $this->rule->setDiscount(.5);
        $product = new GenericProduct('test','t', 2);
        $this->rule->setProduct($product);

        $products = [
            new GenericProduct('test','t', 2),
            new GenericProduct('test','t1', 2),
            new GenericProduct('test','t', 2),
        ];

        $result = $this->rule->calculate($products);
        $this->assertEquals($result->getPrice(), -1);

        $products[] = new GenericProduct('test','t', 2);
        $products[] = new GenericProduct('test','t', 2);
        $result = $this->rule->calculate($products);
        $this->assertEquals($result->getPrice(), -2);

        $result = $this->rule->calculate([]);
        $this->assertEquals($result, null);
    }

}
