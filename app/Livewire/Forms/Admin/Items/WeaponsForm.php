<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\Element;
use App\Enums\WeaponType;
use App\Models\Patch;
use App\Models\Weapon;
use App\Models\WeaponAbility;
use Atomicptr\Functional\Lst;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class WeaponsForm extends Form
{
    public ?Weapon $weapon = null;

    #[Validate('required')]
    public string $name = '';

    public WeaponType $type = WeaponType::AETHER_STRIKERS;

    public ?string $description = null;

    public TemporaryUploadedFile|string|null $icon = null;

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
        $ext = '.'.Lst::last(explode('.', $this->icon->getFilename()));
        $this->icon = $this->icon->storeAs(path: 'uploads/icons/weapons', name: Str::slug($this->name).$ext);

        return [
            ...$this->only([
                'name',
                'type',
                'description',
                'icon',
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
