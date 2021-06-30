<?php

namespace Candidate\Calculator;

/**
 * Class Complex
 * @package Candidate\Calculator
 */
class Complex extends ComplexCalculatorAbstract
{
    /**
     * Complex constructor.
     *
     * @param float   $real      Реальная часть в алгебраической форме.
     * @param float   $imaginary Мнимая часть в алгебраической форме.
     */
    public function __construct(float $real, float $imaginary)
    {
        parent::__construct($real, $imaginary);

        // Преобразовать в тригонометрическую форму.
        $r = $this->abs();
        $arg = $this->arg();

        $this->real = $r * cos($arg);
        $this->imaginary = $r * sin($arg);
    }

    /**
     * @inheritDoc
     */
    public function polarForm(): self
    {
            $r = $this->abs();
            $arg = $this->arg();

            return new static($r * cos($arg), $r * sin($arg));
    }
}
