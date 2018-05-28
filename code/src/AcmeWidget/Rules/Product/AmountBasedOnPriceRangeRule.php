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
class AmountBasedOnPriceRangeRule extends AbstractProductRule
{
    /**
     * lower bound total
     * @var int
     */
    private $priceFrom = 0;

    /**
     * upper bund total
     * @var int
     */
    private $priceTo = 0;

    /**
     * amount to add
     * @var int
     */
    private $amount = 0;

    /**
     * sets the lower bound total (inclusive)
     * @param int $value
     */
    public function setPriceFrom(int $value)
    {
        $this->priceFrom = $value;
    }

    /**
     * gets the lower bound total (inclusive)
     * @return int
     */
    public function getPriceFrom() : int
    {
        return $this->priceFrom;
    }

    /**
     * sets the upper bound total (inclusive)
     * @param int $value
     */
    public function setPriceTo(int $value)
    {
        $this->priceTo = $value;
    }

    /**
     * gets the upper bound total (inclusive)
     * @return int
     */
    public function getPriceTo() : int
    {
        return $this->priceTo;
    }

    /**
     * sets the amount to add if rule applies
     * @param int $value
     */
    public function setAmount(int $value)
    {
        $this->amount = $value;
    }

    /**
     * gets the amount to add if rule applies
     * @return int
     */
    public function getAmount() : int
    {
        return $this->amount;
    }

    /**
     * returns true if the rule can be applied based on the amount specified.
     *
     * So if $amount falls between PriceFrom and PriceTo (inclusive) then the
     * rule can be apllied
     *
     * @param  int $amount
     * @return boolean
     */
    private function ruleApplies($amount)
    {
        return $amount >= $this->getPriceFrom() && $amount <= $this->getPriceTo();
    }


    /**
     * @see AcmeWidget\Rules\Product\ProductRuleInterface::calculate
     * @param  array  $products [
     * @return ProductInterface|null
     */
    public function calculate(array $products) : ?ProductInterface
    {
        $total = array_reduce($products, function ($subTotal, $product) {
            return $subTotal + $product->getPrice();
        }, 0);

        if (false === $this->ruleApplies($total)) {
            return null;
        }

        $class = $this->getProdcutClassFQCN();
        $item = new $class();
        $item->setName($this->getName());
        $item->setCode($this->getCode());
        $item->setPrice($this->getAmount());

        return $item;
    }
}
