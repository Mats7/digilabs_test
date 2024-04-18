<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;
use \Datetime;


final class Task4Presenter extends Nette\Application\UI\Presenter
{
    public function checkDate($dateString)
    {
        //take different formats into account
        $formats = [
            'Y-m-d H:i:s',             //"2024-03-29 23:01:19", etc.
            'l, d-M-Y H:i:s T',        //"Tuesday, 02-Apr-2024 12:17:23 CEST", etc.
        ];

        //try to create a date with one of the formats
        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $dateString);
            if ($date !== false) {
                break;
            }
        }
    
        if ($date === false) {
            return false;
        }

        $currentDate = new DateTime();

        $interval = $currentDate->diff($date);

        //check the difference by months and also by days
        return ($interval->m < 1 || ($interval->m == 1 && $interval->d <= 0));
    }

    public function renderDefault(): void
    {
        $url = 'https://www.digilabs.cz/hiring/data.php';
        $data = file_get_contents($url);
        $arrayData = Json::decode($data, Json::FORCE_ARRAY);

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if (Task4Presenter::checkDate($item['createdAt']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }
}
