<?php

namespace App\Livewire\Page\Admin\Misc\Perks;

use App\Livewire\Forms\Admin\Misc\PerksForm;
use App\Traits\WithPatches;
use Livewire\Component;

class Create extends Component
{
    use WithPatches;

    public PerksForm $form;

    public function mount()
    {
        $this->loadPatches();
        $this->form->patch = $this->newestPatch?->id;
    }

    public function render()
    {
        return view('livewire.page.admin.misc.perks.create');
    }

    public function save()
    {
        $this->form->store();
        $this->redirectRoute('admin.misc.perks', navigate: true);
    }

    public function addValue(): void
    {
        $this->form->addValue();
    }

    public function deleteValue(int $index): void
    {
        $this->form->deleteValue($index);
    }
}
