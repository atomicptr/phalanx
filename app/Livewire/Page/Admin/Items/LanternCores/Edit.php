<?php

namespace App\Livewire\Page\Admin\Items\LanternCores;

use App\Models\LanternCore;
use App\Traits\WithLanternCoreForm;
use App\Traits\WithPatches;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use WithLanternCoreForm;
    use WithPatches;

    #[Url]
    public LanternCore $lanternCore;

    public function mount()
    {
        $this->loadPatches();
        $this->form->setLanternCore($this->lanternCore);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.items.lantern-cores');
    }

    public function render()
    {
        return view('livewire.page.admin.items.lantern-cores.edit');
    }
}
