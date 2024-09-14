<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Livewire\Forms\Admin\Items\ArmourForm;
use App\Traits\WithPatches;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use WithPatches;

    public ArmourForm $form;

    public function mount()
    {
        $this->loadPatches();
        $this->form->patch = $this->newestPatch?->id;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.items.armours');
    }

    public function render()
    {
        return view('livewire.page.admin.items.armours.create');
    }
}
