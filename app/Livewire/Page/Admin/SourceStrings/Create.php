<?php

namespace App\Livewire\Page\Admin\SourceStrings;

use App\Livewire\Forms\SourceStringForm;
use Livewire\Component;

class Create extends Component
{
    public SourceStringForm $form;

    public function render()
    {
        return view('livewire.page.admin.source-strings.create');
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.source-string');
    }
}
