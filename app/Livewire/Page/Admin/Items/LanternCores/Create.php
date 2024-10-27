<?php

namespace App\Livewire\Page\Admin\Items\LanternCores;

use App\Traits\WithLanternCoreForm;
use App\Traits\WithPatches;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use WithLanternCoreForm;
    use WithPatches;

    public function mount()
    {
        $this->loadPatches();
        $this->form->patch = $this->newestPatch?->id;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.items.lantern-cores');
    }

    public function render()
    {
        return view('livewire.page.admin.items.lantern-cores.create');
    }
}
