<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Models\Armour;
use App\Traits\WithArmourForm;
use App\Traits\WithPatches;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithArmourForm;
    use WithFileUploads;
    use WithPatches;

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
