<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Enums\Permissions;
use App\Models\Armour;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $armours;

    public function mount()
    {
        $this->armours = Armour::all()->all(); // TODO: group by behemoth // TODO: always show head / torso / arms / legs
    }

    public function render()
    {
        return view('livewire.page.admin.items.armours.index');
    }

    public function delete(Armour $armour)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $armour->delete();
        $this->redirectRoute('admin.items.armours'); // better way to handle this?
    }

    public function setFromQuickSet()
    {
        $this->form->setFromQuickSet();
    }
}
