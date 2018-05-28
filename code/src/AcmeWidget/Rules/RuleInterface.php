<?php
namespace AcmeWidget\Rules;

/**
 * defines the basic method all rules should implement.
 */
interface RuleInterface
{
    /**
     * the rule name
     * @return string
     */
    public function getName() : string;

    /**
     * the rule code
     * @return string
     */
    public function getCode() : string;
}
