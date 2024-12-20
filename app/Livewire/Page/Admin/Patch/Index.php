<?php

namespace App\Livewire\Page\Admin\Patch;

use App\Enums\Permissions;
use App\Models\Patch;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $patches = [];

    public function mount()
    {
        $this->patches = Patch::orderBy('name', 'DESC')->get()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.patch.index');
    }

    public function delete(Patch $patch)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $patch->delete();
        $this->redirectRoute('admin.patch'); // better way to handle this?
    }
}
