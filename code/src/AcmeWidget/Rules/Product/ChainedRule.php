<?php
namespace AcmeWidget\Rules\Product;

use AcmeWidget\Product\ProductInterface;

/**
 * this will run all rules assigned to it one by one until one returns a non
 * null result
 */
class ChainedRule extends AbstractProductRule
{
    private $rules = [];

    public function addRule(AbstractProductRule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * this will run all rules assigned to it one by one until one returns a non
     * null result§
     *
     * @see AcmeWidget\Rules\Product\ProductRuleInterface::calculate
     * @param  array  $products [
     * @return ProductInterface|null
     */
    public function calculate(array $products) : ?ProductInterface
    {
        foreach ($this->rules as $rule) {
            $result = $rule->calculate($products);
            if (false == is_null($result)) {
                return $result;
            }
        }

        return null;
    }
}
