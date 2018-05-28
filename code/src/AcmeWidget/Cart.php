<?php
namespace AcmeWidget;

use AcmeWidget\Rules\RuleInterface;
use AcmeWidget\Product\ProductInterface;

class Cart
{
    private $rules = [];
    private $catalog = [];

    private $products = [];

    /**
     * Adds a rule to be processed, rule order is important
     * @param RuleInterface $rule
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Adds a Product to the catalogue
     * @param ProductInterface $item
     */
    public function addCatalogItem(ProductInterface $item)
    {
        $this->catalog[$item->getCode()] = $item;
    }

    /**
     * returns a product by code
     * @param  string $code
     * @return ProductInterface
     */
    public function getProduct(string $code) : ?ProductInterface
    {
        return $this->catalog[$code];
    }

    /**
     * returns the products that have been added to cart
     * @return array
     */
    public function getProducts() : array
    {
        return $this->products;
    }

    public function addToCart(string $code) : bool
    {
        $product = $this->getProduct($code);
        if (is_null($product)) {
            return false;
        }

        $this->products[] = $product;

        return true;
    }

    private function applyRules(array $products) : array
    {
        foreach ($this->rules as $rule) {
            $result = $rule->calculate($products);
            if (false === is_null($result)) {
                $products[] = $result;
            }
        }

        return $products;
    }

    public function computeTotal() : int
    {
        // $tmpProducts = $this->getProducts();
        $tmpProducts = $this->applyRules($this->getProducts());

        $total = array_reduce($tmpProducts, function ($subTotal, $product) {
            return $subTotal + $product->getPrice();
        }, 0);

        return $total;
    }
}
