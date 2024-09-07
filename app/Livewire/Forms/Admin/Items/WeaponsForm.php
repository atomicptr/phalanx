<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\Element;
use App\Enums\WeaponType;
use App\Models\Patch;
use App\Models\Weapon;
use App\Models\WeaponAbility;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WeaponsForm extends Form
{
    public ?Weapon $weapon = null;

    #[Validate('required')]
    public string $name = '';

    public WeaponType $type = WeaponType::AETHER_STRIKERS;

    public ?string $description = null;

    #[Validate('image|max:1024')]
    public mixed $icon = null;

    public Element $element = Element::NEUTRAL;

    public ?WeaponAbility $special = null;

    public ?WeaponAbility $passive = null;

    public ?WeaponAbility $active = null;

    public ?int $behemoth = null;

    public int $patch;

    public function mount()
    {
        $this->patch = new Patch;
    }

    public function setWeapon(Weapon $weapon): void
    {
        $this->weapon = $weapon;

        $this->name = $weapon->name;
        $this->type = $weapon->type;
        $this->description = $weapon->description;
        $this->icon = $weapon->icon;
        $this->element = $weapon->element;
        $this->special = $weapon->special;
        $this->passive = $weapon->passive;
        $this->active = $weapon->active;
        $this->behemoth = $weapon->behemoth;
        $this->patch = $weapon->patch;
    }

    protected function grabFormData(): array
    {
        return [
            ...$this->only([
                'name',
                'type',
                'element',
                'behemoth',
                'patch',
            ]),
        ];
    }

    public function store(): void
    {
        $this->validate();

        // TODO: add custom handling for icon, abilities

        Weapon::create([
            ...$this->grabFormData(),
        ]);
    }

    public function update(): void
    {
        $this->validate();

        $this->weapon->update([
            ...$this->grabFormData(),
        ]);
    }
}
