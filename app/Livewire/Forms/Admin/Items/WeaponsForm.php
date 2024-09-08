<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\Element;
use App\Enums\Stat;
use App\Enums\ValueType;
use App\Enums\WeaponTalentOptionType;
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

    public ?array $talents = [];

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
            // TODO: validate talents
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
        $this->talents = $this->prepareTalents($weapon->talents);
        $this->behemoth = $weapon->behemoth;
        $this->patch = $weapon->patch;
    }

    private function prepareValues(?array $values): array
    {
        return Lst::map(
            fn (array $value) => [...$value, 'type' => ValueType::from($value['type'])],
            Lst::map(
                fn (array $value) => array_merge(
                    [
                        'id' => (string) Str::uuid(),
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

    private function prepareTalents(?array $talents): array
    {
        $newTalents = [];

        foreach ($talents ?? [] as $index => $talent) {
            $newTalents[$index] = array_merge(
                [
                    'id' => (string) Str::uuid(),
                    'name' => '',
                    'options' => [],
                ],
                $talent,
            );

            foreach ($talent['options'] ?? [] as $optionIndex => $option) {
                if (! ($option['type'] instanceof WeaponTalentOptionType)) {
                    $option['type'] = WeaponTalentOptionType::from($option['type']);
                }

                switch ($option['type']) {
                    case WeaponTalentOptionType::CUSTOM:
                        $option = array_merge(
                            [
                                'id' => (string) Str::uuid(),
                                'name' => '',
                                'type' => WeaponTalentOptionType::CUSTOM,
                                'values' => [],
                            ],
                            $option,
                        );
                        $option['values'] = $this->prepareValues($option['values']);
                        break;
                    case WeaponTalentOptionType::STAT:
                        $option = array_merge(
                            [
                                'id' => (string) Str::uuid(),
                                'name' => '',
                                'type' => WeaponTalentOptionType::STAT,
                                'stat' => Stat::MIGHT,
                                'value' => 0,
                            ],
                            $option,
                        );

                        if (! ($option['stat'] instanceof Stat)) {
                            $option['stat'] = Stat::from($option['stat']);
                        }
                        break;
                }

                $newTalents[$index]['options'][$optionIndex] = $option;
            }
        }

        return array_values($newTalents);
    }

    protected function grabFormData(): array
    {
        if ($this->icon instanceof TemporaryUploadedFile) {
            $ext = '.'.Lst::last(explode('.', $this->icon->getFilename()));
            $this->icon = $this->icon->storeAs(path: 'uploads/icons/weapons', name: Str::slug($this->name).$ext, options: [
                'disk' => getenv('APP_UPLOAD_DISK', 'public'),
            ]);
        }

        $this->specialValues = Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $this->specialValues);
        $this->passiveValues = Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $this->passiveValues);
        $this->activeValues = Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $this->activeValues);

        // TODO: clean up talents

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
        $this->specialValues[] = ['id' => (string) Str::uuid(), 'name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deleteSpecial(int $index)
    {
        $this->specialValues = Lst::filter(fn (array $val, int $idx) => $index !== $idx, $this->specialValues);
    }

    public function addPassiveValue()
    {
        $this->passiveValues[] = ['id' => (string) Str::uuid(), 'name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deletePassive(int $index)
    {
        $this->passiveValues = Lst::filter(fn (array $val, int $idx) => $index !== $idx, $this->passiveValues);
    }

    public function addActiveValue()
    {
        $this->activeValues[] = ['id' => (string) Str::uuid(), 'name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deleteActive(int $index)
    {
        $this->activeValues = Lst::filter(fn (array $val, int $idx) => $index !== $idx, $this->activeValues);
    }

    public function addTalent(): void
    {
        assert(count($this->talents) < 5);
        $this->talents[] = ['id' => (string) Str::uuid(), 'name' => '', 'options' => []];
    }

    public function addOption(int $index): void
    {
        assert(count($this->talents[$index]['options']) < 5);
        $this->talents[$index]['options'][] = ['id' => (string) Str::uuid(), 'type' => WeaponTalentOptionType::CUSTOM];
    }

    public function deleteOption(int $index, int $optionIndex): void
    {
        $this->talents[$index]['options'] = Lst::filter(fn (array $val, int $idx) => $idx !== $optionIndex, $this->talents[$index]['options']);
    }

    public function addOptionValue(int $index, int $optionIndex): void
    {
        if (! array_key_exists('values', $this->talents[$index]['options'][$optionIndex])) {
            $this->talents[$index]['options'][$optionIndex]['values'] = [];
        }
        $this->talents[$index]['options'][$optionIndex]['values'][] = ['id' => (string) Str::uuid(), 'name' => '', 'value' => '', 'type' => ValueType::CUSTOM];
    }

    public function deleteOptionValue(int $index, int $optionIndex, int $valueIndex): void
    {
        $this->talents[$index]['options'][$optionIndex]['values'] = Lst::filter(fn (array $val, int $idx) => $idx !== $valueIndex, $this->talents[$index]['options'][$optionIndex]['values']);
    }
}
