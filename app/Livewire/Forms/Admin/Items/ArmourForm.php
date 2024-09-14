<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\ArmourType;
use App\Enums\Element;
use App\Models\Armour;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class ArmourForm extends Form
{
    public ?Armour $armour = null;

    #[Validate('required')]
    public string $name = '';

    public ArmourType $type = ArmourType::HEAD;

    public ?string $description = null;

    public TemporaryUploadedFile|string|null $icon = null;

    public Element $element = Element::BLAZE;

    public array $stats = [];

    public ?int $patch = null;

    public function setArmour(Armour $armour)
    {
        $this->armour = $armour;

        $this->name = $armour->name;
        $this->type = $armour->type;
        $this->description = $armour->description;
        $this->icon = $armour->icon;
        $this->element = $armour->element;
        $this->stats = $armour->stats ?? [];
        $this->patch = $armour->patch;
    }

    public function store()
    {
        $this->validate();
        Armour::create($this->all());
    }

    public function update()
    {
        $this->validate();
        $this->armour->update($this->all());
    }
}
