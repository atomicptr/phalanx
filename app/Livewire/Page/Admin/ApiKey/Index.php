<?php

namespace App\Livewire\Page\Admin\ApiKey;

use App\Enums\Permissions;
use App\Models\ApiKey;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
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
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $apiKey->delete();
        $this->redirectRoute('admin.api-key'); // better way to handle this?
    }
}
