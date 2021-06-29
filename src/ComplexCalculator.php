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
     * @const RECTANGULAR_FORM Алгебраическая форма.
     */
    public const RECTANGULAR_FORM = true;

    /**
     * @const POLAR_FORM Тригонометрическая форма.
     */
    public const POLAR_FORM = false;

    /**
     * @var float $real Реальная часть.
     */
    public $real;

    /**
     * @var float $imaginary Мнимая часть.
     */
    public $imaginary;

    /**
     * @var boolean Тип аргументов конструктора.
     */
    private $argForm;

    /**
     * ComplexCalculator constructor.
     *
     * @param float   $real      Реальная часть.
     * @param float   $imaginary Мнимая часть.
     * @param boolean $argForm
     */
    public function __construct(float $real, float $imaginary, bool $argForm = self::RECTANGULAR_FORM)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
        $this->argForm = $argForm;

        // Если алгебраическая форма, то преобразовать в тригонометрическую.
        if ($argForm === self::RECTANGULAR_FORM) {
            $r = $this->abs();
            $arg = $this->arg();

            $this->real = $r * cos($arg);
            $this->imaginary = $r * sin($arg);
        }
    }

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
        } elseif ($c instanceof ComplexCalculator) {
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
        } elseif ($c instanceof ComplexCalculator) {
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
        } elseif ($c instanceof ComplexCalculator) {
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
     * @return ComplexCalculator
     *
     * @throws LogicException Если аргумент не число или не экземпляр ComplexCalculator.
     */
    public function divide($c): self
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
     * Тригонометрическая форма комплексного числа.
     *
     * @return $this
     */
    public function polarForm(): self
    {
        $r = $this->abs();
        $arg = $this->arg();

        return $this->instanceSelf($r * cos($arg), $r * sin($arg));
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
        } else {
            return "$this->real" . ' - ' . (string)abs($this->imaginary) . 'i';
        }
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
        return new static($real, $imaginary, $this->argForm);
    }
}
