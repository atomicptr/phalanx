<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Patch;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PatchForm extends Form
{
    public ?Patch $patch = null;

    #[Validate('required')]
    public string $name = '';

    public bool $live = false;

    public bool $confidential = false;

    public function setPatch(Patch $patch): void
    {
        $this->patch = $patch;

        $this->name = $patch->name ?? '';
        $this->live = $patch->live ?? false;
        $this->confidential = $patch->confidential ?? false;
    }

    public function store(): void
    {
        $this->validate(); // TODO: validate patch name

        Patch::create($this->all());
    }

    public function update(): void
    {
        $this->validate(); // TODO: validate version name

        $this->patch->update($this->all());
    }
}
