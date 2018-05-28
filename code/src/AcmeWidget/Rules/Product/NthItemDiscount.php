<?php
namespace AcmeWidget\Rules\Product;

use AcmeWidget\Product\ProductInterface;

/**
 * represents a rule that is applied based on quantity, for example buy 2
 * and get 50% off the second item
 *
 * this class will assess all prodcuts looking for matching product codes then
 * return a prodcut item which the price is
 * discount * item price ( number of items / quantity)
 */
class NthItemDiscount extends AbstractProductRule
{
    /**
     * the quantity needed for discount
     * @var int
     */
    private $itemQuantity;

    /**
     * discount
     * @var float
     */
    private $discount;

    /**
     * the prodcut to apply the discount
     * @var ProductInterface
     */
    private $product;

    /**
     * sets the number of items needed to get a discount, each $quantity item
     * will be discounted
     * @param int $quantity
     */
    public function setItemQuantity(int $quantity)
    {
        $this->itemQuantity = $quantity;
    }

    /**
     * gets the number of items needed to get a discount
     * @return int
     */
    public function getItemQuantity() : int
    {
        return $this->itemQuantity;
    }

    /**
     * sets the discount
     * @param float $discount
     */
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
    }

    /**
     * gets the discount
     * @return float
     */
    public function getDiscount() : float
    {
        return $this->discount;
    }

    /**
     * sets the prodcut to be matched
     * @param ProductInterface $product
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * gets the prodcut to be matched
     * @return ProductInterface
     */
    public function getProduct() : ProductInterface
    {
        return $this->product;
    }

    /**
     * @see AcmeWidget\Rules\Product\ProductRuleInterface::calculate
     * @param  array  $products [
     * @return ProductInterface|null
     */
    public function calculate(array $products) : ?ProductInterface
    {
        $product = $this->getProduct();

        $matchingElements = array_filter($products, function ($item) use ($product) {
            return $product->getCode() == $item->getCode();
        });


        if (count($matchingElements) < $this->getItemQuantity()) {
            return null;
        }

        $discountedItemPrice = -1 * $product->getPrice() * $this->getDiscount();
        $itemsGrouped = intval(count($matchingElements) / $this->getItemQuantity());
        $price = $discountedItemPrice * $itemsGrouped;

        $class = $this->getProdcutClassFQCN();
        $discount = new $class();
        $discount->setName($this->getName());
        $discount->setCode($this->getCode());
        $discount->setPrice($price);

        return $discount;
    }
}
