<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Traits\WithArmourForm;
use App\Traits\WithPatches;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithArmourForm;
    use WithFileUploads;
    use WithPatches;

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
