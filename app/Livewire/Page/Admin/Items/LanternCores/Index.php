<?php

namespace App\Livewire\Page\Admin\Items\LanternCores;

use App\Models\LanternCore;
use Livewire\Component;

class Index extends Component
{
    public array $lanternCores;

    public function mount()
    {
        $this->lanternCores = LanternCore::all()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.items.lantern-cores.index');
    }

    public function delete(LanternCore $perk)
    {
        $perk->delete();
        $this->redirectRoute('admin.misc.lantern-cores'); // better way to handle this?
    }
}
