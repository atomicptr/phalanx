<?php

namespace App\Traits;

use App\Livewire\Forms\Admin\Items\WeaponsForm;

trait WithWeaponsForm
{
    public WeaponsForm $form;

    public function addSpecialValue(): void
    {
        $this->form->addSpecialValue();
    }

    public function deleteSpecial(int $index): void
    {
        $this->form->deleteSpecial($index);
    }

    public function addPassiveValue(): void
    {
        $this->form->addPassiveValue();
    }

    public function deletePassive(int $index): void
    {
        $this->form->deletePassive($index);
    }

    public function addActiveValue(): void
    {
        $this->form->addActiveValue();
    }

    public function deleteActive(int $index): void
    {
        $this->form->deleteActive($index);
    }

    public function addTalent(): void
    {
        $this->form->addTalent();
    }

    public function addOption(int $index): void
    {
        $this->form->addOption($index);
    }

    public function deleteOption(int $index, int $optionIndex): void
    {
        $this->form->deleteOption($index, $optionIndex);
    }

    public function addOptionValue(int $index, int $optionIndex): void
    {
        $this->form->addOptionValue($index, $optionIndex);
    }

    public function deleteOptionValue(int $index, int $optionIndex, int $valueIndex): void
    {
        $this->form->deleteOptionValue($index, $optionIndex, $valueIndex);
    }
}
