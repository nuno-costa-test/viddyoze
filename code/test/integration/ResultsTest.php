<?php

use PHPUnit\Framework\TestCase;
use AcmeWidget\Cart;
use AcmeWidget\Product\Widget;
use AcmeWidget\Product\GenericProduct;
use AcmeWidget\Rules\Product\AmountBasedOnPriceRangeRule;
use AcmeWidget\Rules\Product\NthItemDiscount;
use AcmeWidget\Rules\Product\ChainedRule;

class CartIntegrationTest extends TestCase
{
    private $cart;

    private function setUpCatalogue()
    {
        $this->cart->addCatalogItem(new Widget('Red Widget', 'R01', 3295));
        $this->cart->addCatalogItem(new Widget('Green Widget', 'G01', 2495));
        $this->cart->addCatalogItem(new Widget('Blue Widget', 'B01', 795));
    }

    private function setUpRules()
    {
        $halfPriceOnSecondItem = new NthItemDiscount('2 half price', '50OFF', GenericProduct::class);
        $halfPriceOnSecondItem->setItemQuantity(2);
        $halfPriceOnSecondItem->setDiscount(.5);
        $halfPriceOnSecondItem->setProduct($this->cart->getProduct('R01'));
        $this->cart->addRule($halfPriceOnSecondItem);

        $shipping1 = new AmountBasedOnPriceRangeRule('Shipping', 'SH01', GenericProduct::class);
        $shipping1->setPriceFrom(0);
        $shipping1->setPriceTo(4999);
        $shipping1->setAmount(495);

        $shipping2 = new AmountBasedOnPriceRangeRule('Shipping', 'SH02', GenericProduct::class);
        $shipping2->setPriceFrom(5000);
        $shipping2->setPriceTo(9000);
        $shipping2->setAmount(295);

        $shipping = new ChainedRule('', '', GenericProduct::class);
        $shipping->addRule($shipping1);
        $shipping->addRule($shipping2);
        $this->cart->addRule($shipping);
    }

    public function setUp()
    {
        $this->cart = new Cart();
        $this->setUpCatalogue();
        $this->setUpRules();
    }

    public function testResults1()
    {
        $this->cart->addToCart('B01');
        $this->cart->addToCart('G01');
        $result = $this->cart->computeTotal();

        $this->assertEquals($result, 3785);
    }

    public function testResults2()
    {
        $this->cart->addToCart('R01');
        $this->cart->addToCart('R01');
        $result = $this->cart->computeTotal();

        $this->assertEquals($result, 5437);
    }

    public function testResults3()
    {
        $this->cart->addToCart('R01');
        $this->cart->addToCart('G01');
        $result = $this->cart->computeTotal();

        $this->assertEquals($result, 6085);
    }

    public function testResults4()
    {
        $this->cart->addToCart('B01');
        $this->cart->addToCart('B01');
        $this->cart->addToCart('R01');
        $this->cart->addToCart('R01');
        $this->cart->addToCart('R01');
        $result = $this->cart->computeTotal();

        $this->assertEquals($result, 9827);
    }
}
