<?php

namespace App\Livewire\Page\Admin\Items\Armours;

use App\Models\Armour;
use Livewire\Component;

class Index extends Component
{
    public array $armours;

    public function mount()
    {
        $this->armours = Armour::all()->all(); // TODO check confidentiality
    }

    public function delete(Armour $armour)
    {
        $armour->delete();
        $this->redirectRoute('admin.items.armours'); // better way to handle this?
    }

    public function render()
    {
        return view('livewire.page.admin.items.armours.index');
    }
}
