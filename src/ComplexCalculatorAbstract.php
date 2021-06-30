<?php

namespace Candidate\Calculator;

use LogicException;

/**
 * Class ComplexCalculatorBase
 * @package Candidate\Calculator
 */
abstract class ComplexCalculatorAbstract
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
     * @param float   $real      Реальная часть.
     * @param float   $imaginary Мнимая часть.
     */
    public function __construct(float $real, float $imaginary)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
     }

    /**
     * Тригонометрическая форма комплексного числа.
     *
     * @return $this
     */
    abstract function polarForm();

    /**
     * Сложение.
     *
     * @param mixed $c
     *
     * @return $this
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function add($c): self
    {
        if (is_numeric($c)) {
            $real = $this->real + $c;
            $imaginary = $this->imaginary;
        } elseif ($c instanceof ComplexCalculatorAbstract) {
            $real = $this->real + $c->real;
            $imaginary = $this->imaginary + $c->imaginary;
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }

        return $this->instanceSelf($real, $imaginary);
    }

    /**
     * Вычитание.
     *
     * @param mixed $c
     *
     * @return $this
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function subtract($c): self
    {
        if (is_numeric($c)) {
            $real = $this->real - $c;
            $imaginary = $this->imaginary;
        } elseif ($c instanceof ComplexCalculatorAbstract) {
            $real = $this->real - $c->real;
            $imaginary = $this->imaginary - $c->imaginary;
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }

        return $this->instanceSelf($real, $imaginary);
    }

    /**
     * Деление.
     *
     * @param mixed $c
     *
     * @return $this
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function multiply($c): self
    {
        if (is_numeric($c)) {
            $real = $c * $this->real;
            $imaginary = $c * $this->imaginary;
        } elseif ($c instanceof ComplexCalculatorAbstract) {
            $real = $this->real * $c->real - $this->imaginary * $c->imaginary;
            $imaginary = $this->imaginary * $c->real + $this->real * $c->imaginary;
        } else {
            throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
        }

        return $this->instanceSelf($real, $imaginary);
    }

    /**
     * Деление.
     *
     * @param mixed $c
     *
     * @return $this
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function divide($c): self
    {
        if (is_numeric($c)) {
            $real = $this->real / $c;
            $imaginary = $this->imaginary / $c;

            return $this->instanceSelf($real, $imaginary);

        } elseif ($c instanceof ComplexCalculatorAbstract) {
            return $this->multiply($c->inverse());
        }

        throw new LogicException('Аргумент должен быть числом или экземпляром ComplexCalculator.');
    }

    /**
     * Инверсия.
     *
     * @return $this
     *
     * @throws LogicException
     */
    public function inverse(): self
    {
        if ($this->real == 0 && $this->imaginary == 0) {
            throw new LogicException('Инверсия невозможна');
        }

        return $this->complexConjugate()->divide($this->abs() ** 2);
    }

    /**
     * Сопряжение.
     *
     * @return $this
     */
    public function complexConjugate(): self
    {
        return $this->instanceSelf($this->real, -1 * $this->imaginary);
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
     * Аргумент комплексного числа.
     *
     * @return float
     */
    public function arg() : float
    {
        return atan2($this->imaginary, $this->real);
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
        }

        return "$this->real" . ' - ' . (string)abs($this->imaginary) . 'i';
    }

    /**
     * Инстанцировать новый экземпляр ComplexCalculator.
     *
     * @param float $real      Реальная часть.
     * @param float $imaginary Мнимая часть.
     *
     * @return $this
     */
    private function instanceSelf(float $real, float $imaginary) : self
    {
        return new static($real, $imaginary);
    }
}