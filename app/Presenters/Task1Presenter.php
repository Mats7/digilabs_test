<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;


final class Task1Presenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $url = 'https://www.digilabs.cz/hiring/data.php';
        $data = file_get_contents($url);
        $arrayData = Json::decode($data, Json::FORCE_ARRAY);

        $jokesAll = [];

        foreach ($arrayData as $item)
        {
            if(strlen($item['joke']) <= 120)
                $jokesAll[] = $item['joke'];
        }
        
        //random joke
        $data = $jokesAll[array_rand($jokesAll)];

        //dont cut words
        $middle = strrpos(substr($data, 0, intval(floor(strlen($data) / 2))), ' ') + 1;

        $dataUpper = substr($data, 0, $middle);
        $dataLower = substr($data, $middle);

        $this->template->dataUpper = $dataUpper;
        $this->template->dataLower = $dataLower;
    }
}
