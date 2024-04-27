<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class Task2Presenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $arrayData = JsonDecodePresenter::decodeJson();

        $validItems = [];

        foreach ($arrayData as $item)
        {
            if ($this->checkInitials($item['name']))
            {
                $validItems[] = $item;
            }
        }

        $this->template->data = $validItems;
    }

    
    private function checkInitials(string $fullName): bool
    {
        $names = explode(" ", $fullName);
        
        //cannot compare, if there is only one name
        if (count($names) < 2)
        {
            return false;
        }
    
        //extract initials (surname is the last name)
        $firstNameInitial = strtoupper($names[0][0]);
        $lastNameInitial = strtoupper($names[count($names) - 1][0]);
    
        return $firstNameInitial === $lastNameInitial;
    }
}
