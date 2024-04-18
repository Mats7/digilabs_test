<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;


final class Task2Presenter extends Nette\Application\UI\Presenter
{
    public function checkInitials($fullName)
    {
        $names = explode(" ", $fullName);
        
        //cannot compare, if there is only one name
        if (count($names) < 2)
        {
            return false;
        }
    
        //extract initials (surname is the last name)
        $firstNameInitial = strtoupper(substr($names[0], 0, 1));
        $lastNameInitial = strtoupper(substr($names[count($names) - 1], 0, 1));
    
        return $firstNameInitial === $lastNameInitial;
    }

    public function renderDefault(): void
    {
        $url = 'https://www.digilabs.cz/hiring/data.php';
        $data = file_get_contents($url);
        $arrayData = Json::decode($data, Json::FORCE_ARRAY);

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if (Task2Presenter::checkInitials($item['name']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }
}
