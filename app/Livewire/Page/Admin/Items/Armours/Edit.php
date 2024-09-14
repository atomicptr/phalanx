<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Livewire\Forms\Admin\Items\ArmourForm;
use App\Models\Armour;
use App\Traits\WithPatches;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use WithPatches;

    public ArmourForm $form;

    #[Url]
    public Armour $armour;

    public function mount()
    {
        $this->loadPatches();
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
}
