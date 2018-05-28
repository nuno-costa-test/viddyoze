<?php
namespace AcmeWidget\Rules\Product;

use AcmeWidget\Rules\AbstractRule;
use AcmeWidget\Product\ProductInterface;

abstract class AbstractProductRule extends AbstractRule implements ProductRuleInterface
{

    /**
     * @inheritdoc
     */
    abstract public function calculate(array $prodcuts) : ?ProductInterface;
}
