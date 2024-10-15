<?php

namespace App\Traits;

use App\Livewire\Forms\Admin\Items\ArmourForm;
use Atomicptr\Functional\Lst;

trait WithArmourForm
{
    public ArmourForm $form;

    public function addStatSet(): void
    {
        $this->form->addStatSet();
    }

    public function addPerk(int $index): void
    {
        $this->form->addPerk($index);
    }

    public function removePerk(int $index, int $perkIndex): void
    {
        $this->form->removePerk($index, $perkIndex);
    }

    public function selectedPerks(int $index, int $except): array
    {
        return Lst::filter(fn (int $id) => $id !== $except, $this->form->selectedPerks($index));
    }

    public function removeStatSet(int $index): void
    {
        $this->form->removeStatSet($index);
    }
}
