<?php
namespace AcmeWidget\Rules\Product;

use AcmeWidget\Product\ProductInterface;

/**
 * defines a rule that applies to the products in the cart
 *
 * the rules of this type most likely need to implement an extra method or
 * property defining the FQCN of a product class to return
 */
interface ProductRuleInterface
{
    /**
     * evaluates the products in the cart and return a product item with the
     * needed changes or null
     *
     * for example buy 2 pay one would return a product with a price of minus
     * prodcut price (if prodcut price is 10 then a product with -10 price would
     * be returned)
     * @param  array $prodcuts
     * @return ProductInterface
     */
    public function calculate(array $products) : ?ProductInterface;
}
