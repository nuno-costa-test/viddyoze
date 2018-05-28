<?php
namespace AcmeWidget\Rules;

use AcmeWidget\Rules\RuleInterface;


/**
 * base actions useful for all Rules
 * @var [type]
 */
abstract class AbstractRule implements RuleInterface
{
    /**
     * fully qualified class name for the product type to be returned
     * @var string
     */
    private $fqcn;

    /**
     * rule name
     * @var string
     */
    private $name;

    /**
     * rule code
     * @var string
     */
    private $code;


    public function __construct(string $name = '', string $code = '', string $fqcn = '')
    {
        $this->setName($name);
        $this->setCode($code);
        $this->setProdcutClassFQCN($fqcn);
    }
    /**
     * sets the fully qualified class name for the product type to be returned
     * @return string
     */
    public function setProdcutClassFQCN(string $fqcn)
    {
        $this->fqcn = $fqcn;
    }
    /**
     * gets the fully qualified class name for the product type to be returned
     * @var string
     */
    public function getProdcutClassFQCN() : string
    {
        return $this->fqcn;
    }

    /**
     * sets the rule name
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * gets the rule name
     * @return string $name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * sets the rule code
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * gets the rule code
     * @return string $code
     */
    public function getCode() : string
    {
        return $this->code;
    }
}
