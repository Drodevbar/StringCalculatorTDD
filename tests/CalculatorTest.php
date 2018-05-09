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
        $total = $this->getTotalForPattern("");

        $this->assertEquals(0, $total);
    }

    /**
     * @test
     */
    public function itTakesOneNumberAndReturnsCorrectTotal()
    {
        $total = $this->getTotalForPattern("5");

        $this->assertEquals(5, $total);
    }

    /**
     * @test
     */
    public function itTakesTwoNumbersAndReturnsCorrectTotal()
    {
        $total = $this->getTotalForPattern("1,4");

        $this->assertEquals(5, $total);
    }

    /**
     * @test
     */
    public function itTakesMoreThanTwoNumbersAndReturnsCorrectTotal()
    {
        $total = $this->getTotalForPattern("1,1,1,2");

        $this->assertEquals(5, $total);
    }

    /**
     * @test
     */
    public function itAllowsNewLinesBetweenNumbersInsteadOfCommas()
    {
        $total = $this->getTotalForPattern("1\n2,3");

        $this->assertEquals(6, $total);
    }

    /**
     * @test
     */
    public function itAllowsCustomDelimiters()
    {
        $total = $this->getTotalForPattern("//[;]\n1;2");

        $this->assertEquals(3, $total);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionWhenNegativeNumberPassed()
    {
        $this->getTotalForPattern("-1,2,-3");
    }

    /**
     * @test
     */
    public function itIgnoresNumbersBiggerThanOneThousand()
    {
        $total = $this->getTotalForPattern("1001,2");

        $this->assertEquals(2, $total);
    }

    /**
     * @test
     */
    public function itAllowsDelimitersWithAnyLength()
    {
        $total = $this->getTotalForPattern("//[***]\n1***2***3");

        $this->assertEquals(6, $total);
    }

    /**
     * @test
     */
    public function itAllowsMultipleDelimiters()
    {
        $total = $this->getTotalForPattern("//[*][%]\n1*2%3");

        $this->assertEquals(6, $total);
    }

    /**
     * @test
     */
    public function itAllowsMultipleDelimitersWithAnyLength()
    {
        $total = $this->getTotalForPattern("//[***][%]\n1***2%3");

        $this->assertEquals(6, $total);
    }

    private function getTotalForPattern(string $pattern) : int
    {
        $calculator = new Calculator();

        return $calculator->add($pattern);
    }
}
