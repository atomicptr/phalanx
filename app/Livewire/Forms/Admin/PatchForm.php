<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Patch;
use App\Rules\VersionStringRule;
use Livewire\Form;

class PatchForm extends Form
{
    public ?Patch $patch = null;

    public string $name = '';

    public bool $live = false;

    public bool $confidential = false;

    public function rules()
    {
        return [
            'name' => ['required', new VersionStringRule],
        ];
    }

    public function setPatch(Patch $patch): void
    {
        $this->patch = $patch;

        $this->name = $patch->name ?? '';
        $this->live = $patch->live ?? false;
        $this->confidential = $patch->confidential ?? false;
    }

    public function store(): void
    {
        $this->validate();

        Patch::create($this->all());
    }

    public function update(): void
    {
        $this->validate();

        $this->patch->update($this->all());
    }
}
