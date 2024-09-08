<?php

namespace App\Livewire\Page\Admin\Items\Weapons;

use App\Models\Weapon;
use App\Traits\WithPatches;
use App\Traits\WithWeaponsForm;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use WithPatches;
    use WithWeaponsForm;

    #[Url]
    public Weapon $weapon;

    public function mount()
    {
        $this->loadPatches();
        $this->form->setWeapon($this->weapon);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.items.weapons');
    }

    public function render()
    {
        return view('livewire.page.admin.items.weapons.edit');
    }
}
