<?php

namespace Candidate\Calculator;

use LogicException;

/**
 * Class ComplexCalculator
 * @package Candidate\Calculator
 */
class ComplexCalculator
{
    /**
     * @var float $real Реальная часть.
     */
    public $real;

    /**
     * @var float $imaginary Мнимая часть.
     */
    public $imaginary;

    /**
     * ComplexCalculator constructor.
     *
     * @param float $real      Реальная часть.
     * @param float $imaginary Мнимая часть.
     */
    public function __construct(float $real, float $imaginary)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    /**
     * Сложение.
     *
     * @param mixed $c
     *
     * @return ComplexCalculator
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function add($c): ComplexCalculator
    {
        if (is_numeric($c)) {
            $real = $this->real + $c;
            $imaginary = $this->imaginary;
        } elseif ($c instanceof ComplexCalculator) {
            $real = $this->real + $c->real;
            $imaginary = $this->imaginary + $c->imaginary;
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }

        return new ComplexCalculator($real, $imaginary);
    }

    /**
     * Вычитание.
     *
     * @param mixed $c
     *
     * @return ComplexCalculator
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function subtract($c): ComplexCalculator
    {
        if (is_numeric($c)) {
            $real = $this->real - $c;
            $imaginary = $this->imaginary;
        } elseif ($c instanceof ComplexCalculator) {
            $real = $this->real - $c->real;
            $imaginary = $this->imaginary - $c->imaginary;
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }

        return new ComplexCalculator($real, $imaginary);
    }

    /**
     * Деление.
     *
     * @param mixed $c
     *
     * @return ComplexCalculator
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function multiply($c): ComplexCalculator
    {
        if (is_numeric($c)) {
            $real = $c * $this->real;
            $imaginary = $c * $this->imaginary;
        } elseif ($c instanceof ComplexCalculator) {
            $real = $this->real * $c->real - $this->imaginary * $c->imaginary;
            $imaginary = $this->imaginary * $c->real + $this->real * $c->imaginary;
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }

        return new ComplexCalculator($real, $imaginary);
    }

    /**
     * Деление.
     *
     * @param mixed $c
     *
     * @return ComplexCalculator
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function divide($c): ComplexCalculator
    {
        if (is_numeric($c)) {
            $real = $this->real / $c;
            $imaginary = $this->imaginary / $c;
            return new ComplexCalculator($real, $imaginary);
        } elseif ($c instanceof ComplexCalculator) {
            return $this->multiply($c->inverse());
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }
    }

    /**
     * Инверсия.
     *
     * @return ComplexCalculator
     *
     * @throws LogicException
     */
    public function inverse(): ComplexCalculator
    {
        if ($this->real == 0 && $this->imaginary == 0) {
            throw new LogicException('Инверсия невозможна');
        }

        return $this->complexConjugate()->divide($this->abs() ** 2);
    }

    /**
     * Сопряжение.
     *
     * @return ComplexCalculator
     */
    public function complexConjugate(): ComplexCalculator
    {
        return new ComplexCalculator($this->real, -1 * $this->imaginary);
    }

    /**
     * Модуль.
     *
     * @return number
     */
    public function abs()
    {
        return sqrt($this->real ** 2 + $this->imaginary ** 2);
    }

    /**
     * Строковое представление.
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->real == 0 & $this->imaginary == 0) {
            return '0';
        } elseif ($this->real == 0) {
            return "$this->imaginary" . 'i';
        } elseif ($this->imaginary == 0) {
            return "$this->real";
        } elseif ($this->imaginary > 0) {
            return "$this->real" . ' + ' . "$this->imaginary" . 'i';
        } else {
            return "$this->real" . ' - ' . (string) \abs($this->imaginary) . 'i';
        }
    }
}
