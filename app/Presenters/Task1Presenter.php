<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

const JOKE_LENGTH = 120;

final class Task1Presenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $arrayData = JsonDecodePresenter::decodeJson();

        $jokesAll = [];

        foreach ($arrayData as $item)
        {
            if(strlen($item['joke']) <= JOKE_LENGTH)
            {
                $jokesAll[] = $item['joke'];
            }
        }
        
        //random joke
        $data = $jokesAll[array_rand($jokesAll)];

        //dont cut words
        $middle = strrpos(substr($data, 0, (int)floor(strlen($data) / 2)), ' ') + 1;

        $dataUpper = substr($data, 0, $middle);
        $dataLower = substr($data, $middle);

        $this->template->dataUpper = $dataUpper;
        $this->template->dataLower = $dataLower;
    }
}
