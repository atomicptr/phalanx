<?php

namespace App\Livewire\Page\Admin\ApiKey;

use App\Livewire\Forms\Admin\ApiKeyForm;
use App\Models\ApiKey;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    #[Url]
    public ApiKey $apiKey;

    public ApiKeyForm $form;

    public function mount()
    {
        $this->form->setApiKey($this->apiKey);
    }

    public function render()
    {
        return view('livewire.page.admin.api-key.edit');
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.api-key');
    }
}
