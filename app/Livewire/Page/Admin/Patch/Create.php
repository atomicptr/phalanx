<?php

namespace App\Livewire\Page\Admin\Patch;

use App\Livewire\Forms\Admin\PatchForm;
use Livewire\Component;

class Create extends Component
{
    public PatchForm $form;

    public function render()
    {
        return view('livewire.page.admin.patch.create');
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.patch');
    }
}
