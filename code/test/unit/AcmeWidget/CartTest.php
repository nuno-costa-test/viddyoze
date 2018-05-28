<?php
use PHPUnit\Framework\TestCase;
use AcmeWidget\Cart;
use AcmeWidget\Product\GenericProduct;
use AcmeWidget\Rules\Product\AmountBasedOnPriceRangeRule;

class CartTest extends TestCase
{
    private $cart;

    public function setUp()
    {
        $this->cart = new Cart();
        $this->cart->addCatalogItem(new GenericProduct('Test1', 'T01', 1));
        $this->cart->addCatalogItem(new GenericProduct('Test2', 'T02', 1));
        $this->cart->addCatalogItem(new GenericProduct('Test3', 'T03', 1));

        $testRule = new AmountBasedOnPriceRangeRule('Rule1', 'R01', GenericProduct::class);
        $testRule->setPriceFrom(0);
        $testRule->setPriceTo(10);
        $testRule->setAmount(97);
        $this->cart->addRule($testRule);
    }

    public function testAddToCartInvalidCode()
    {
        $result = $this->cart->addToCart('foo');
        $this->assertFalse($result);
        $this->assertEquals(count($this->cart->getProducts()), 0);
    }

    public function testAddToCart()
    {
        $result = $this->cart->addToCart('T01');
        $this->assertTrue($result);
        $this->assertEquals(count($this->cart->getProducts()), 1);
    }

    public function testComputeTotal()
    {
        $this->cart->addToCart('T01');
        $this->cart->addToCart('T01');
        $this->cart->addToCart('T01');

        $result = $this->cart->computeTotal();
        $this->assertEquals($result, 100);

    }
}
