<?php

namespace App\Livewire\Page\Admin\SourceStrings;

use App\Livewire\Forms\SourceStringForm;
use App\Models\SourceString;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    #[Url]
    public SourceString $sourceString;

    public SourceStringForm $form;

    public function mount()
    {
        $this->form->setSourceString($this->sourceString);
    }

    public function render()
    {
        return view('livewire.page.admin.source-strings.edit');
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.source-string');
    }
}
