<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Livewire\Forms\Admin\Items\ArmourForm;
use App\Models\Armour;
use App\Traits\WithPatches;
use App\Traits\WithPerksABCD;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use WithPatches;
    use WithPerksABCD;

    #[Url]
    public Armour $armour;

    public ArmourForm $form;

    public function mount()
    {
        $this->loadPatches();
        $this->loadPerks();
        $this->form->setArmour($this->armour);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.items.armours');
    }

    public function render()
    {
        return view('livewire.page.admin.items.armours.edit');
    }

    public function setFromQuickSet()
    {
        $this->form->setFromQuickSet();
    }
}
