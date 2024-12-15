<?php

namespace App\Livewire\Forms;

use App\Models\SourceString;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SourceStringForm extends Form
{
    public ?SourceString $sourceString = null;

    #[Validate('required')]
    public string $ident = '';

    #[Validate('required')]
    public string $content = '';

    public bool $manual = true;

    public function setSourceString(SourceString $sourceString): void
    {
        $this->sourceString = $sourceString;

        $this->ident = $sourceString->ident;
        $this->content = $sourceString->content;
    }

    private function prepare(): void
    {
        $this->ident = Str::slug($this->ident);
        $this->manual = true;
    }

    public function store(): void
    {
        $this->validate();

        $this->prepare();

        SourceString::create($this->all());
    }

    public function update(): void
    {
        $this->validate();

        $this->prepare();

        $this->sourceString->update($this->all());
    }
}
