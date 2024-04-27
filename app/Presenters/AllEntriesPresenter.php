<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class AllEntriesPresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $arrayData = JsonDecodePresenter::decodeJson();

        $this->template->data = $arrayData;
    }
}
