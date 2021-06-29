<?php


namespace Candidate\Tests;

use Candidate\Calculator\ComplexCalculator;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Class ComplexTest
 * @package Candidate\Tests
 */
class ComplexTest extends TestCase
{
    /**
     * __get.
     */
    public function testGet()
    {
        // Given
        $r       = 1;
        $i       = 2;
        $complex = new ComplexCalculator($r, $i);

        // Then
        $this->assertEquals($r, $complex->real);
        $this->assertEquals($i, $complex->imaginary);
    }

    /**
     * @dataProvider dataProviderForComplexConjugate
     *
     * @param        number $real
     * @param        number $imaginary
     *
     * @return void
     */
    public function testComplexConjugate($real, $imaginary) : void
    {
        $c = new ComplexCalculator($real, $imaginary);
        $cc = $c->complexConjugate();

        $this->assertEquals($c->real, $cc->real);
        $this->assertEquals($c->imaginary, -1 * $cc->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForComplexConjugate(): array
    {
        return [
            [0, 0],
            [1, 0],
            [0, 1],
            [1, 1],
            [1, 2],
            [3, 7],
        ];
    }

    /**
     * @dataProvider dataProviderForAbs
     * @param number $r
     * @param number $i
     * @param number $expected
     *
     * @return void
     */
    public function testAbs($r, $i, $expected) : void
    {
        $c = new ComplexCalculator($r, $i);

        $abs = $c->abs();

        $this->assertEquals($expected, $abs);
    }

    /**
     * @return array
     */
    public function dataProviderForAbs(): array
    {
        return [
            [0, 0, 0],
            [1, 0, 1],
            [0, 1, 1],
            [1, 2, \sqrt(5)],
            [2, 1, \sqrt(5)],
            [2, 2, \sqrt(8)],
            [-1, 0, 1],
            [0, -1, 1],
            [-1, 2, \sqrt(5)],
            [2, -1, \sqrt(5)],
            [-2, -2, \sqrt(8)],
        ];
    }

    /**
     *
     * Сложение.
     *
     * @dataProvider dataProviderForAdd
     * @param        array  $complex1
     * @param        array  $complex2
     * @param        array  $expected
     */
    public function testAdd(array $complex1, array $complex2, array $expected) : void
    {
        $c1 = new ComplexCalculator($complex1['r'], $complex1['i']);
        $c2 = new ComplexCalculator($complex2['r'], $complex2['i']);

        $result = $c1->add($c2);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForAdd(): array
    {
        return [
            [
                ['r' => 3, 'i' => 2],
                ['r' => 4, 'i' => -3],
                ['r' => 7, 'i' => -1],
            ],
            [
                ['r' => 0, 'i' => 0],
                ['r' => 4, 'i' => -3],
                ['r' => 4, 'i' => -3],
            ],
            [
                ['r' => -3, 'i' => -2],
                ['r' => 4, 'i' => 3],
                ['r' => 1, 'i' => 1],
            ],
            [
                ['r' => 7, 'i' => 6],
                ['r' => 4, 'i' => 4],
                ['r' => 11, 'i' => 10],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForAddReal
     *
     * @param $complex
     * @param $real
     * @param $expected
     *
     * @return void
     */
    public function testAddReal($complex, $real, $expected) : void
    {
        $c = new ComplexCalculator($complex['r'], $complex['i']);

        $result = $c->add($real);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForAddReal() : array
    {
        return [
            [
                ['r' => 3, 'i' => 2],
                5,
                ['r' => 8, 'i' => 2],
            ],
            [
                ['r' => 0, 'i' => 0],
                5,
                ['r' => 5, 'i' => 0],
            ],
            [
                ['r' => 3, 'i' => 2],
                -2,
                ['r' => 1, 'i' => 2],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForSubtract
     * @param        array  $complex1
     * @param        array  $complex2
     * @param        array  $expected
     *
     * @return void
     */
    public function testSubtract(array $complex1, array $complex2, array $expected) : void
    {
        $c1 = new ComplexCalculator($complex1['r'], $complex1['i']);
        $c2 = new ComplexCalculator($complex2['r'], $complex2['i']);

        $result = $c1->subtract($c2);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForSubtract(): array
    {
        return [
            [
                ['r' => 3, 'i' => 2],
                ['r' => 4, 'i' => -3],
                ['r' => -1, 'i' => 5],
            ],
            [
                ['r' => 3, 'i' => 2],
                ['r' => 4, 'i' => -3],
                ['r' => -1, 'i' => 5],
            ],
            [
                ['r' => 0, 'i' => 0],
                ['r' => 4, 'i' => -3],
                ['r' => -4, 'i' => 3],
            ],
            [
                ['r' => -3, 'i' => -2],
                ['r' => 4, 'i' => 3],
                ['r' => -7, 'i' => -5],
            ],
            [
                ['r' => 7, 'i' => 6],
                ['r' => 4, 'i' => 4],
                ['r' => 3, 'i' => 2],
            ],
        ];
    }


    /**
     * @dataProvider dataProviderForSubtractReal
     * @param $complex
     * @param $real
     * @param $expected
     *
     * @return void
     */
    public function testSubtractReal($complex, $real, $expected) : void
    {
        $c = new ComplexCalculator($complex['r'], $complex['i']);

        $result = $c->subtract($real);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForSubtractReal(): array
    {
        return [
            [
                ['r' => 3, 'i' => 2],
                5,
                ['r' => -2, 'i' => 2],
            ],
            [
                ['r' => 0, 'i' => 0],
                5,
                ['r' => -5, 'i' => 0],
            ],
            [
                ['r' => 3, 'i' => 2],
                -2,
                ['r' => 5, 'i' => 2],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMultiply
     * @param        array  $complex1
     * @param        array  $complex2
     * @param        array  $expected
     *
     * @return void
     */
    public function testMultiply(array $complex1, array $complex2, array $expected) : void
    {
        $c1 = new ComplexCalculator($complex1['r'], $complex1['i']);
        $c2 = new ComplexCalculator($complex2['r'], $complex2['i']);

        $result = $c1->multiply($c2);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForMultiply(): array
    {
        return [
            [
                ['r' => 3, 'i' => 2],
                ['r' => 1, 'i' => 4],
                ['r' => -5, 'i' => 14],
            ],
            [
                ['r' => 3, 'i' => 13],
                ['r' => 7, 'i' => 17],
                ['r' => -200, 'i' => 142],
            ],
            [
                ['r' => 6, 'i' => 8],
                ['r' => 4, 'i' => -9],
                ['r' => 96, 'i' => -22],
            ],
            [
                ['r' => -56, 'i' => 3],
                ['r' => -84, 'i' => -4],
                ['r' => 4716, 'i' => -28],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMultiplyReal
     * @param $complex
     * @param $real
     * @param $expected
     *
     * @return void
     */
    public function testMultiplyReal($complex, $real, $expected) : void
    {
        $c = new ComplexCalculator($complex['r'], $complex['i']);

        $result = $c->multiply($real);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForMultiplyReal() : array
    {
        return [
            [
                ['r' => 3, 'i' => 1],
                2,
                ['r' => 6, 'i' => 2],
            ],
            [
                ['r' => 30, 'i' => 13],
                2,
                ['r' => 60, 'i' => 26],
            ],
        ];
    }

    /**
     * Деление.
     *
     * @dataProvider dataProviderForDivide
     * @param        array  $complex1
     * @param        array  $complex2
     * @param        array  $expected
     *
     * @return void
     */
    public function testDivide(array $complex1, array $complex2, array $expected) : void
    {
        $c1 = new ComplexCalculator($complex1['r'], $complex1['i']);
        $c2 = new ComplexCalculator($complex2['r'], $complex2['i']);

        $result = $c1->divide($c2);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForDivide(): array
    {
        return [
            [
                ['r' => 3, 'i' => 2],
                ['r' => 4, 'i' => -3],
                ['r' => 0.24, 'i' => 0.68],
            ],
            [
                ['r' => 5, 'i' => 5],
                ['r' => 6, 'i' => 2],
                ['r' => 1, 'i' => 1 / 2],
            ],
            [
                ['r' => 6, 'i' => 2],
                ['r' => 7, 'i' => -7],
                ['r' => 2 / 7, 'i' => 4 / 7],
            ],
            [
                ['r' => -56, 'i' => 3],
                ['r' => -84, 'i' => -4],
                ['r' => 69 / 104, 'i' => -7 / 104],
            ],
        ];
    }

    /**
     * Деление.
     *
     * @dataProvider dataProviderForDivideReal
     * @param $complex
     * @param $real
     * @param $expected
     *
     * @return void
     */
    public function testDivideReal($complex, $real, $expected) : void
    {
        $c = new ComplexCalculator($complex['r'], $complex['i']);

        $result = $c->divide($real);

        $this->assertEquals($expected['r'], $result->real);
        $this->assertEquals($expected['i'], $result->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForDivideReal() : array
    {
        return [
            [
                ['r' => 4, 'i' => 1],
                2,
                ['r' => 2, 'i' => 1 / 2],
            ],
            [
                ['r' => 60, 'i' => 9],
                3,
                ['r' => 20, 'i' => 3],
            ],
        ];
    }

    /**
     * Неверный формат аргументов сложения.
     *
     * @return void
     */
    public function testComplexAddException() : void
    {
        $complex = new ComplexCalculator(1, 1);

        $this->expectException(LogicException::class);

        $complex->add("string");
    }

    /**
     * Неверный формат аргументов вычитания.
     *
     * @return void
     */
    public function testComplexSubtractException() : void
    {
        $complex = new ComplexCalculator(1, 1);

        $this->expectException(LogicException::class);

        $complex->add("string");
    }

    /**
     * Неверный формат аргументов деления.
     *
     * @return void
     */
    public function testComplexMultiplyException() : void
    {
        $complex = new ComplexCalculator(1, 1);

        $this->expectException(LogicException::class);

        $complex->add("string");
    }

    /**
     * @dataProvider dataProviderForInverse
     * @param        number $r
     * @param        number $i
     * @param        number $expected_r
     * @param        number $expected_i
     *
     * @return void
     */
    public function testInverse($r, $i, $expected_r, $expected_i) : void
    {
        $c = new ComplexCalculator($r, $i);

        $inverse = $c->inverse();

        $this->assertEquals($expected_r, $inverse->real);
        $this->assertEquals($expected_i, $inverse->imaginary);
    }

    /**
     * @return array
     */
    public function dataProviderForInverse(): array
    {
        return [
            [1, 0, 1, 0],
            [0, 1, 0, -1],
            [1, 1, 1 / 2, -1 / 2],
            [4, 6, 1 / 13, -3 / 26],
            [-4, 6, -1 / 13, -3 / 26],
            [4, -6, 1 / 13, 3 / 26],
            [-4, -6, -1 / 13, 3 / 26],
        ];
    }

    /**
     * Неверный формат аргументов инверсии.
     *
     * @return void
     */
    public function testInverseException()
    {
        $complex = new ComplexCalculator(0, 0);

        $this->expectException(LogicException::class);

        $complex->inverse();
    }

    /**
     * Тригонометрическая форма комплексного числа.
     *
     * @dataProvider dataProviderForPolarForm
     *
     * @param        number $r1
     * @param        number $i1
     * @param        number $r2
     * @param        number $i2
     *
     * @return void
     */
    public function testPolarForm($r1, $i1, $r2, $i2) : void
    {
        $c        = new ComplexCalculator($r1, $i1);
        $expected = new ComplexCalculator($r2, $i2);

        $polar_form = $c->polarForm();

        $this->assertEqualsWithDelta($expected->real, $polar_form->real, 0.00001);
        $this->assertEqualsWithDelta($expected->imaginary, $polar_form->imaginary, 0.00001);
    }

    /**
     * @return array
     */
    public function dataProviderForPolarForm(): array
    {
        return [
            [5, 2, 5.3851648071 * cos(0.3805063771), 5.3851648071 *  sin(0.3805063771)],
            [49.90, 25.42, 56.0016642610 * cos(0.4711542561), 56.0016642610 *  sin(0.4711542561)],
            [-1, -1, 1.4142135624 * cos(-2.3561944902), 1.41421 *  sin(-2.3561944902)],
            [1, 0, 1 * cos(0), 1 *  sin(0)],
            [0, 1, 1 * cos(1.5707963268), 1 *  sin(1.5707963268)],
            [0, 0, 0, 0],
            [M_PI, 2, 3.7241917782 * cos(0.5669115049), 3.7241917782 *  sin(0.5669115049)],
            [8, 9, 12.0415945788 * cos(0.8441539861), 12.0415945788 *  sin(0.8441539861)],
            [814, -54, 815.7891884550 * cos(-0.0662420059), 815.7891884550 *  sin(-0.0662420059)],
            [-5, -3, 5.8309518948 * cos(-2.6011731533), 5.8309518948 *  sin(-2.6011731533)],
        ];
    }
}