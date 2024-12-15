<?php

namespace App\Livewire\Page\Admin\Items\LanternCores;

use App\Enums\Permissions;
use App\Models\LanternCore;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $lanternCores;

    public function mount()
    {
        $this->lanternCores = LanternCore::orderBy('name', 'ASC')->get()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.items.lantern-cores.index');
    }

    public function delete(LanternCore $perk)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $perk->delete();
        $this->redirectRoute('admin.items.lantern-cores'); // better way to handle this?
    }
}
