<?php

namespace App\Livewire\Page\Admin\Patch;

use App\Livewire\Forms\Admin\PatchForm;
use App\Models\Patch;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    #[Url]
    public Patch $patch;

    public PatchForm $form;

    public function mount()
    {
        $this->form->setPatch($this->patch);
    }

    public function render()
    {
        return view('livewire.page.admin.patch.edit', []);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.patch');
    }
}
