<?php

namespace App\Livewire\Page\Admin\Builds\Meta;

use App\Livewire\Forms\BuildForm;
use App\Traits\WithPatches;
use Livewire\Component;

class Create extends Component
{
    use WithPatches;

    public BuildForm $form;

    public function mount()
    {
        $this->loadPatches();
        $this->form->patch = $this->newestPatch?->id;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.builds.meta');
    }

    public function render()
    {
        return view('livewire.page.admin.builds.meta.create');
    }
}
