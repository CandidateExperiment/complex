<?php

namespace Candidate\Calculator;

/**
 * Class ComplexPolar
 * @package Candidate\Calculator
 */
class ComplexPolar extends ComplexCalculatorAbstract
{
    /**
     * Тригонометрическая форма комплексного числа.
     *
     * @return $this
     */
    public function polarForm(): self
    {
        return $this;
    }
}