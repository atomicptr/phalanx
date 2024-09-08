<?php

namespace App\Livewire\Page\Admin\Items\Weapons;

use App\Traits\WithPatches;
use App\Traits\WithWeaponsForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use WithPatches;
    use WithWeaponsForm;

    public function mount()
    {
        $this->loadPatches();
        $this->form->patch = $this->newestPatch?->id;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.items.weapons');
    }

    public function render()
    {
        return view('livewire.page.admin.items.weapons.create');
    }
}
