<?php

namespace App\Traits;

use App\Livewire\Forms\Admin\Items\WeaponsForm;

trait WithWeaponsForm
{
    public WeaponsForm $form;

    public function addSpecialValue()
    {
        $this->form->addSpecialValue();
    }

    public function deleteSpecial(int $index)
    {
        $this->form->deleteSpecial($index);
    }

    public function addPassiveValue()
    {
        $this->form->addPassiveValue();
    }

    public function deletePassive(int $index)
    {
        $this->form->deletePassive($index);
    }

    public function addActiveValue()
    {
        $this->form->addActiveValue();
    }

    public function deleteActive(int $index)
    {
        $this->form->deleteActive($index);
    }
}
