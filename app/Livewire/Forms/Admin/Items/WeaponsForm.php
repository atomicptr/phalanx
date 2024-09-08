<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\Element;
use App\Enums\ValueType;
use App\Enums\WeaponType;
use App\Models\Patch;
use App\Models\Weapon;
use App\Rules\ContainsValuesRule;
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

    public ?string $specialName = null;

    public ?string $specialDescription = null;

    public ?array $specialValues = [];

    public ?string $passiveName = null;

    public ?string $passiveDescription = null;

    public ?array $passiveValues = [];

    public ?string $activeName = null;

    public ?string $activeDescription = null;

    public ?array $activeValues = [];

    public ?int $behemoth = null;

    public int $patch;

    public function mount()
    {
        $this->patch = new Patch;
    }

    public function rules()
    {
        return [
            'specialDescription' => new ContainsValuesRule($this->specialValues),
            'passiveDescription' => new ContainsValuesRule($this->passiveValues),
            'activeDescription' => new ContainsValuesRule($this->activeValues),
        ];
    }

    public function setWeapon(Weapon $weapon): void
    {
        $this->weapon = $weapon;

        $this->name = $weapon->name;
        $this->type = $weapon->type;
        $this->description = $weapon->description;
        $this->icon = $weapon->icon;
        $this->element = $weapon->element;
        $this->specialName = $weapon->specialName;
        $this->specialDescription = $weapon->specialDescription;
        $this->specialValues = $this->prepareValues($weapon->specialValues);
        $this->passiveName = $weapon->passiveName;
        $this->passiveDescription = $weapon->passiveDescription;
        $this->passiveValues = $this->prepareValues($weapon->passiveValues);
        $this->activeName = $weapon->activeName;
        $this->activeDescription = $weapon->activeDescription;
        $this->activeValues = $this->prepareValues($weapon->activeValues);
        $this->behemoth = $weapon->behemoth;
        $this->patch = $weapon->patch;
    }

    private function prepareValues(?array $values)
    {
        return Lst::map(
            fn (array $value) => [...$value, 'type' => ValueType::from($value['type'])],
            Lst::map(
                fn (array $value) => array_merge(
                    [
                        'name' => '',
                        'value' => '',
                        'type' => ValueType::CUSTOM,
                    ],
                    $value
                ),
                $values
            )
        );
    }

    protected function grabFormData(): array
    {
        if ($this->icon instanceof TemporaryUploadedFile) {
            $ext = '.'.Lst::last(explode('.', $this->icon->getFilename()));
            $this->icon = $this->icon->storeAs(path: 'uploads/icons/weapons', name: Str::slug($this->name).$ext);
        }

        $this->specialValues = Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $this->specialValues);
        $this->passiveValues = Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $this->passiveValues);
        $this->activeValues = Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $this->activeValues);

        return $this->all();
    }

    public function store(): void
    {
        $this->validate();
        Weapon::create($this->grabFormData());
    }

    public function update(): void
    {
        $this->validate();
        $this->weapon->update($this->grabFormData());
    }

    public function addSpecialValue()
    {
        $this->specialValues[] = ['name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deleteSpecial(int $index)
    {
        $this->specialValues = Lst::filter(fn (array $val, int $idx) => $index !== $idx, $this->specialValues);
    }

    public function addPassiveValue()
    {
        $this->passiveValues[] = ['name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deletePassive(int $index)
    {
        $this->passiveValues = Lst::filter(fn (array $val, int $idx) => $index !== $idx, $this->passiveValues);
    }

    public function addActiveValue()
    {
        $this->activeValues[] = ['name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deleteActive(int $index)
    {
        $this->activeValues = Lst::filter(fn (array $val, int $idx) => $index !== $idx, $this->activeValues);
    }
}
