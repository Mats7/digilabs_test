<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use \Datetime;


final class Task4Presenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $arrayData = JsonDecodePresenter::decodeJson();

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if ($this->checkDate($item['createdAt']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }


    private function checkDate(string $dateString): bool
    {
        //take different formats into account
        $formats = [
            'Y-m-d H:i:s',             //"2024-03-29 23:01:19", etc.
            'l, d-M-Y H:i:s T',        //"Tuesday, 02-Apr-2024 12:17:23 CEST", etc.
        ];

        //try to create a date with one of the formats
        foreach ($formats as $format) 
        {
            $date = DateTime::createFromFormat($format, $dateString);
            if ($date !== false) 
            {
                break;
            }
        }
    
        if ($date === false) {
            return false;
        }

        $currentDate = new DateTime();

        $interval = $currentDate->diff($date);

        //check the difference by years, months and days
        return ($interval->y < 1 && ($interval->m < 1 || ($interval->m == 1 && $interval->d <= 0)));
    }
}
