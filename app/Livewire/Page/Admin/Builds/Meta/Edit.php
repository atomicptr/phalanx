<?php

namespace App\Livewire\Page\Admin\Builds\Meta;

use App\Livewire\Forms\BuildForm;
use App\Models\Build;
use App\Traits\WithPatches;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    use WithPatches;

    public BuildForm $form;

    #[Url]
    public Build $build;

    public function mount()
    {
        $this->loadPatches();
        $this->form->setBuild($this->build);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.builds.meta');
    }

    public function render()
    {
        return view('livewire.page.admin.builds.meta.edit');
    }
}
