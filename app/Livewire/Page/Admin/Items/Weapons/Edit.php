<?php

namespace App\Livewire\Page\Admin\Items\Weapons;

use App\Livewire\Forms\Admin\Items\WeaponsForm;
use App\Models\Patch;
use App\Models\Weapon;
use Atomicptr\Functional\Lst;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    #[Url]
    public Weapon $weapon;

    public array $patches = [];

    public WeaponsForm $form;

    public function mount()
    {
        $patches = Patch::orderBy('name', 'DESC')->get()->all();
        $this->patches = Lst::map(fn (Patch $patch) => [$patch['id'], $patch['name']], $patches); // TODO: dont show confidential patches here if user has no access
        $this->patches = array_combine(Lst::map([Lst::class, 'first'], $this->patches), Lst::map([Lst::class, 'second'], $this->patches));

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
