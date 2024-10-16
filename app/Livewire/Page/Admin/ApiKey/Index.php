<?php

namespace App\Livewire\Page\Admin\ApiKey;

use App\Models\ApiKey;
use Livewire\Component;

class Index extends Component
{
    public array $apiKeys = [];

    public function mount()
    {
        $this->apiKeys = ApiKey::all()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.api-key.index');
    }

    public function delete(ApiKey $apiKey)
    {
        $apiKey->delete();
        $this->redirectRoute('admin.api-key'); // better way to handle this?
    }
}
