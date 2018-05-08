<?php

namespace Kata;

class Calculator
{
    private const DEFAULT_ALLOWED_NUMBERS_DELIMITER = [
        "\n"
    ];

    public function add(string $numbers) : int
    {
        $customDelimiter = $this->getCustomDelimiterIfPassed($numbers);

        $allowedDelimiters = $customDelimiter ?? self::DEFAULT_ALLOWED_NUMBERS_DELIMITER;

        $commaSeparatedNumbers = $this->getNumbersOnlySeparatedByComma($numbers, $allowedDelimiters);

        $args = explode(',', $commaSeparatedNumbers);

        if (!$this->checkForNegativeNumbers($args)) {
            return (int) array_sum($args);
        }
    }

    private function getNumbersOnlySeparatedByComma(string $input, array $allowedDelimiters) : string
    {
        $pattern = $this->createPattern($allowedDelimiters);

        return preg_replace($pattern, ',', $input);
    }

    private function createPattern(array $allowedDelimiters) : string
    {
        $pattern = '/([';
        foreach ($allowedDelimiters as $index => $delimiter) {
            $pattern .= $delimiter;
            if ($index < count($allowedDelimiters) - 1) {
                $pattern .= '|';
            }
        }
        $pattern .= '])/';

        return $pattern;
    }

    private function getCustomDelimiterIfPassed(string $input) : ?array
    {
        $result = preg_match('/\/\/(.)\n/', $input, $matches);

        return ($result !== 0) ? [$matches[1]] : null;
    }

    private function checkForNegativeNumbers(array $numbers) : bool
    {
        $negativeNumbers = '';
        foreach ($numbers as &$number) {
            if ($number < 0) {
                $negativeNumbers .= " {$number}";
            }
        }

        if (empty($negativeNumbers)) {
            return false;
        }
        throw new \InvalidArgumentException("Negative numbers passed:{$negativeNumbers}");
    }
}
