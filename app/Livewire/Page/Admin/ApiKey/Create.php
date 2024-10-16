<?php

namespace App\Livewire\Page\Admin\ApiKey;

use App\Livewire\Forms\Admin\ApiKeyForm;
use Livewire\Component;

class Create extends Component
{
    public ApiKeyForm $form;

    public function render()
    {
        return view('livewire.page.admin.api-key.create');
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.api-key');
    }
}
