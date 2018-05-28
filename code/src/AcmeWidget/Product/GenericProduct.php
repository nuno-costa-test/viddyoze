<?php
namespace AcmeWidget\Product;

/**
 * Generic Product
 */
class GenericProduct implements ProductInterface
{
    /**
     * product name
     * @var string
     */
    private $name;

    /**
     * product code
     * @var string
     */
    private $code;

    /**
     * product price
     * @var int
     */
    private $price;

    public function __construct(string $name = '', string $code = '', int $price = 0)
    {
        $this->setName($name);
        $this->setCode($code);
        $this->setPrice($price);
    }

    /**
     * Sets th prodcut name
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * gets the product name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Sets th prodcut code
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * gets the product code
     * @return string
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * sets the prodcut price in cents
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * gets the prodcut price in cents
     * @return float
     */
    public function getPrice() : float
    {
        return $this->price;
    }
}
