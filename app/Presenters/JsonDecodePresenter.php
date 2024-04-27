<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;


final class JsonDecodePresenter extends Nette\Application\UI\Presenter
{
    public static function decodeJson(): array
    {
        $url = 'https://www.digilabs.cz/hiring/data.php';
        $data = file_get_contents($url);

        return Json::decode($data, true);
    }
}
