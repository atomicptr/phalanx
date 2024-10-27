<?php

namespace App\Traits;

use App\Livewire\Forms\Admin\Items\LanternCoreForm;

trait WithLanternCoreForm
{
    public LanternCoreForm $form;

    public function addActiveValue()
    {
        $this->form->addActiveValue();
    }

    public function deleteActive(int $index)
    {
        $this->form->deleteActive($index);
    }

    public function addPassiveValue()
    {
        $this->form->addPassiveValue();
    }

    public function deletePassive(int $index)
    {
        $this->form->deletePassive($index);
    }
}
