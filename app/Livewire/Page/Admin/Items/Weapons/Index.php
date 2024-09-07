<?php

namespace App\Livewire\Page\Admin\Items\Weapons;

use App\Models\Weapon;
use Livewire\Component;

class Index extends Component
{
    public array $weapons;

    public function mount()
    {
        $this->weapons = Weapon::all()->all(); // TODO check confidentiality
    }

    public function render()
    {
        return view('livewire.page.admin.items.weapons.index');
    }

    public function delete(Weapon $weapon)
    {
        $weapon->delete();
        $this->redirectRoute('admin.items.weapons'); // better way to handle this?
    }
}
