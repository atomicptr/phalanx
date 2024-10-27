<?php

namespace App\Livewire\Page\Admin\Misc\Perks;

use App\Models\Perk;
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
        $perk->delete();
        $this->redirectRoute('admin.misc.perks'); // better way to handle this?
    }
}
