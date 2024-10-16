<?php

namespace App\Livewire\Forms\Admin;

use App\Models\ApiKey;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ApiKeyForm extends Form
{
    public ?ApiKey $apiKey = null;

    #[Validate('required')]
    public string $name = '';

    public function setApiKey(ApiKey $apiKey)
    {
        $this->apiKey = $apiKey;

        $this->name = $this->apiKey->name;
    }

    public function store(): void
    {
        $this->validate();

        ApiKey::create($this->all());
    }

    public function update(): void
    {
        $this->validate();

        $this->apiKey->update($this->all());
    }
}
