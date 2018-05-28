<?php
use PHPUnit\Framework\TestCase;
use AcmeWidget\Product\GenericProduct  ;

class GenericProductTest extends TestCase
{
    private $prodcut;

    public function setUp()
    {
        $this->prodcut = new GenericProduct();
    }

    public function testGetSetName()
    {
        $this->prodcut->setName('foo');
        $this->assertEquals($this->prodcut->getName(), 'foo');
    }

    public function testGetSetCode()
    {
        $this->prodcut->setCode('foo');
        $this->assertEquals($this->prodcut->getCode(), 'foo');
    }

    public function testGetSetPrice()
    {
        $this->prodcut->setPrice(123);
        $this->assertEquals($this->prodcut->getPrice(), 123);
    }

    public function testConstructor()
    {
        $prodcut = new GenericProduct  ();
        $this->assertEquals('', $prodcut->getName());
        $this->assertEquals('', $prodcut->getCode());
        $this->assertEquals(0, $prodcut->getPrice());

        $prodcut = new GenericProduct  ('name', 'code', 1);
        $this->assertEquals('name', $prodcut->getName());
        $this->assertEquals('code', $prodcut->getCode());
        $this->assertEquals(1, $prodcut->getPrice());
    }
}
