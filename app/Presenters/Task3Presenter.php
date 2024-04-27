<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class Task3Presenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $arrayData = JsonDecodePresenter::decodeJson();

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if ($this->checkEquation($item['firstNumber'], $item['secondNumber'], $item['thirdNumber']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }


    private function checkEquation(int $firstNo, int $secondNo, int $thirdNo): bool
    {
        if($firstNo % 2 === 0)
        {
            return ($firstNo / $secondNo == $thirdNo);
        }
        else
        {
            return false;
        }
    }
}

