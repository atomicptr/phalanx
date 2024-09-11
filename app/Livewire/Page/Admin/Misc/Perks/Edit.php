<?php

namespace App\Livewire\Page\Admin\Misc\Perks;

use App\Livewire\Forms\Admin\Misc\PerksForm;
use App\Models\Perk;
use App\Traits\WithPatches;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    use WithPatches;

    public PerksForm $form;

    #[Url]
    public Perk $perk;

    public function mount()
    {
        $this->loadPatches();
        $this->form->setPerk($this->perk);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.misc.perks');
    }

    public function render()
    {
        return view('livewire.page.admin.misc.perks.edit');
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
