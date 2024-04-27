<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class Task5Presenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $arrayData = JsonDecodePresenter::decodeJson();

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if ($this->checkCalculation($item['calculation']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }


    private function checkCalculation(string $equation): bool
    {
        // number-operator-number-operator-number (with minus signs or whitespaces)
        preg_match('/^\s*(-?\d+)\s*([=\-+*\/])\s*(-?\d+)\s*([=\-+*\/])\s*(-?\d+)\s*$/', $equation, $matches);

        if (count($matches) === 6) 
        {
            $operand1 = (int)$matches[1];
            $operator1 = $matches[2];
            $operand2 = (int)$matches[3];
            $operator2 = $matches[4];
            $operand3 = (int)$matches[5];

            //if the first operator is "="
            if($operator1 === '=')
            {
                return $this->checkExpectedResult($operand2, $operand3, $operand1, $operator2);
            }

            //if the second operator is "="
            if($operator2 === '=')
            {
                return $this->checkExpectedResult($operand1, $operand2, $operand3, $operator1);
            }
        }

        return false;
    }


    private function checkExpectedResult(int $operand1, int $operand2, int $operand3, string $operator) : bool
    {
        switch ($operator) 
        {
            case '+':
                $expectedResult = $operand1 + $operand2;
                break;
            case '-':
                $expectedResult = $operand1 - $operand2;
                break;
            case '*':
                $expectedResult = $operand1 * $operand2;
                break;
            case '/':
                if ($operand2 === 0) 
                {
                    return false;
                }
                $expectedResult = $operand1 / $operand2;
                break;
            default:
                return false;
        }

        return $expectedResult === $operand3;
    }
}