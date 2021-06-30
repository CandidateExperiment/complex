<?php

namespace Candidate\Calculator;

/**
 * Class ComplexPolar
 * @package Candidate\Calculator
 */
class ComplexPolar extends ComplexCalculatorAbstract
{
    /**
     * @inheritDoc
     */
    public function polarForm(): self
    {
        return $this;
    }
}
