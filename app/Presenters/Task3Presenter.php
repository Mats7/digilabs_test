<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;

final class Task3Presenter extends Nette\Application\UI\Presenter
{
    public function checkEquation($firstNo, $secondNo, $thirdNo)
    {
        if($firstNo % 2 == 0)
            return ($firstNo / $secondNo == $thirdNo);
        else
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
            if (Task3Presenter::checkEquation($item['firstNumber'], $item['secondNumber'], $item['thirdNumber']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }
}

