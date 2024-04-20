<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;


final class Task5Presenter extends Nette\Application\UI\Presenter
{
    public function checkExpectedResult($operand1, $operand2, $operand3, $operator)
    {
        switch ($operator) {
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
                if ($operand2 == 0) {
                    return false;
                }
                $expectedResult = $operand1 / $operand2;
                break;
            default:
                return false;
        }

        return $expectedResult == $operand3;
    }

    public function checkCalculation($equation)
    {
        // number-operator-number-operator-number (with minus signs or whitespaces)
        preg_match('/^\s*(-?\d+)\s*([=\-+*\/])\s*(-?\d+)\s*([=\-+*\/])\s*(-?\d+)\s*$/', $equation, $matches);

        if (count($matches) == 6) {
            $operator = null;
            $operand1 = intval($matches[1]);
            $operator1 = $matches[2];
            $operand2 = intval($matches[3]);
            $operator2 = $matches[4];
            $operand3 = intval($matches[5]);

            //if the first operator is "="
            if($operator1 == '=')
            {
                return Task5Presenter::checkExpectedResult($operand2, $operand3, $operand1, $operator2);
            }

            //if the second operator is "="
            if($operator2 == '=')
            {
                return Task5Presenter::checkExpectedResult($operand1, $operand2, $operand3, $operator1);
            }
        }

        return false;
    }

    public function renderDefault(): void
    {
        $url = 'https://www.digilabs.cz/hiring/data.php';
        $data = file_get_contents($url);
        $arrayData = Json::decode($data, Json::FORCE_ARRAY);

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if (Task5Presenter::checkCalculation($item['calculation']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }
}

