<?php

namespace Kata\Tests;

use PHPUnit\Framework\TestCase;
use Kata\Calculator;

class CalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function itTakesEmptyStringAndReturnsZero()
    {
        $calculator = new Calculator();

        $total = $calculator->add("");

        $this->assertEquals(0, $total);
    }

    /**
     * @test
     */
    public function itTakesOneNumberAndReturnsCorrectTotal()
    {
        $calculator = new Calculator();

        $total = $calculator->add("5");

        $this->assertEquals(5, $total);
    }

    /**
     * @test
     */
    public function itTakesTwoNumbersAndReturnsCorrectTotal()
    {
        $calculator = new Calculator();

        $total = $calculator->add("1,4");

        $this->assertEquals(5, $total);
    }

    /**
     * @test
     */
    public function itTakesMoreThanTwoNumbersAndReturnsCorrectTotal()
    {
        $calculator = new Calculator();

        $total = $calculator->add("1,1,1,2");

        $this->assertEquals(5, $total);
    }

    /**
     * @test
     */
    public function itAllowsNewLinesBetweenNumbersInsteadOfCommas()
    {
        $calculator = new Calculator();

        $total = $calculator->add("1\n2,3");

        $this->assertEquals(6, $total);
    }

    /**
     * @test
     */
    public function itSupportsCustomDelimiters()
    {
        $calculator = new Calculator();

        $total = $calculator->add("//;\n1;2");

        $this->assertEquals(3, $total);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionWhenNegativeNumberPassed()
    {
        $calculator = new Calculator();

        $calculator->add("-1,2,-3");
    }
}
