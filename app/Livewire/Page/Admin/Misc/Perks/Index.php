<?php

namespace App\Livewire\Page\Admin\Misc\Perks;

use App\Enums\Permissions;
use App\Models\Perk;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $perks;

    public function mount()
    {
        $this->perks = Perk::all()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.misc.perks.index');
    }

    public function delete(Perk $perk)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $perk->delete();
        $this->redirectRoute('admin.misc.perks'); // better way to handle this?
    }
}
