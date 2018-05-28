<?php
namespace AcmeWidget\Product;

/**
 * Defines methods a product needs to implement
 */
interface ProductInterface
{
    /**
     * Sets th prodcut name
     * @param string $name
     */
    public function setName(string $name);

    /**
     * gets the product name
     * @return string
     */
    public function getName() : string ;

    /**
     * Sets th prodcut code
     * @param string $code
     */
    public function setCode(string $code);

    /**
     * gets the product code
     * @return string
     */
    public function getCode() : string;

    /**
     * sets the prodcut price in cents
     * @param float $price
     */
    public function setPrice(float $price);

    /**
     * gets the prodcut price in cents
     * @return float
     */
    public function getPrice() : float;
}
