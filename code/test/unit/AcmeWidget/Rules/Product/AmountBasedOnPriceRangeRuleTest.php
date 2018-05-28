<?php
use PHPUnit\Framework\TestCase;
use AcmeWidget\Rules\Product\AmountBasedOnPriceRangeRule;
use AcmeWidget\Product\GenericProduct;

class AmountBasedOnPriceRangeRuleTest extends TestCase
{
    private $rule;

    public function setUp()
    {
        $this->rule = new AmountBasedOnPriceRangeRule('rule', 'test', GenericProduct::class);
    }

    public function testSetGetPriceFrom()
    {
        $this->rule->setPriceFrom(1);
        $this->assertEquals($this->rule->getPriceFrom(), 1);
    }

    public function testSetGetPriceTo()
    {
        $this->rule->setPriceTo(1);
        $this->assertEquals($this->rule->getPriceTo(), 1);
    }

    public function testSetGetAmount()
    {
        $this->rule->setAmount(1);
        $this->assertEquals($this->rule->getAmount(), 1);
    }

    public function testCalculateNoMatch()
    {
        $this->rule->setPriceFrom(99);
        $this->rule->setPriceTo(99);
        $this->rule->setAmount(1);

        $products = [new GenericProduct('test','t', 2)];
        $this->assertEquals($this->rule->calculate($products), null);

        $products = [];
        $this->assertEquals($this->rule->calculate($products), null);
    }

    public function testCalculateMatch()
    {
        $this->rule->setPriceFrom(1);
        $this->rule->setPriceTo(10);
        $this->rule->setAmount(1);

        $products = [new GenericProduct('test','t', 2)];
        $result =$this->rule->calculate($products);

        $this->assertEquals($result->getPrice(), 1);
    }
}
