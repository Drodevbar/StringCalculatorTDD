<?php

namespace Kata;

class Calculator
{
    private const DEFAULT_ALLOWED_NUMBER_DELIMITERS = ["\n"];

    /**
     * @var string|array
     */
    private $numbers;

    /**
     * @var array
     */
    private $delimiters;

    public function add(string $numbers) : int
    {
        $this->numbers = $numbers;

        $this->delimiters = $this->getDelimiters();

        $this->transformNumbersToArray();

        $this->checkForNegativeNumbers();

        return $this->makeAddition();
    }

    private function getDelimiters() : array
    {
        $customDelimiters = $this->getCustomDelimitersIfPassed();

        if ($customDelimiters) {
            $this->removeDelimiterPart();
            return $customDelimiters;
        }

        return self::DEFAULT_ALLOWED_NUMBER_DELIMITERS;
    }

    private function getCustomDelimitersIfPassed() : ?array
    {
        $result = preg_match_all('/\[([^\[\]]+)\]/', $this->numbers, $matches);

        return ($result !== 0) ? $matches[1] : null;
    }

    private function removeDelimiterPart() : void
    {
        $this->numbers = preg_replace('/\/\/\[(.+)\]\n/', '', $this->numbers);
    }

    private function transformNumbersToArray() : void
    {
        $commaSeparatedNumbers = $this->getNumbersOnlySeparatedByComma();

        $this->numbers = explode(',', $commaSeparatedNumbers);
    }

    private function getNumbersOnlySeparatedByComma() : string
    {
        $pattern = $this->createPattern();

        return preg_replace($pattern, ',', $this->numbers);
    }

    private function createPattern() : string
    {
        $pattern = '/([';
        foreach ($this->delimiters as $index => $delimiter) {
            $pattern .= $delimiter;
            if ($index < count($this->delimiters) - 1) {
                $pattern .= '|';
            }
        }
        $pattern .= '])/';

        return $pattern;
    }

    private function checkForNegativeNumbers() : bool
    {
        $negativeNumbers = '';
        foreach ($this->numbers as $number) {
            if ($number < 0) {
                $negativeNumbers .= " {$number}";
            }
        }

        if (empty($negativeNumbers)) {
            return false;
        }
        throw new \InvalidArgumentException("Negative numbers passed:{$negativeNumbers}");
    }

    private function makeAddition() : int
    {
        $this->ignoreNumbersBiggerThanOneThousand();

        return (int) array_sum($this->numbers);
    }

    private function ignoreNumbersBiggerThanOneThousand() : void
    {
        foreach ($this->numbers as $index => $number) {
            if ($number > 1000) {
                unset($this->numbers[$index]);
            }
        }
    }
}
