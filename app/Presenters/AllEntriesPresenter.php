<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;


final class AllEntriesPresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $url = 'https://www.digilabs.cz/hiring/data.php';
        $data = file_get_contents($url);

        $arrayData = Json::decode($data, Json::FORCE_ARRAY);

        $this->template->data = $arrayData;
    }
}
