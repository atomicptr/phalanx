<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\Element;
use App\Enums\Stat;
use App\Enums\WeaponTalentOptionType;
use App\Enums\WeaponType;
use App\Models\Weapon;
use App\Rules\ContainsValuesRule;
use App\Utils\ValuesUtil;
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

    public ?int $patch = null;

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
        $this->specialValues = ValuesUtil::prepare($weapon->specialValues);
        $this->passiveName = $weapon->passiveName;
        $this->passiveDescription = $weapon->passiveDescription;
        $this->passiveValues = ValuesUtil::prepare($weapon->passiveValues);
        $this->activeName = $weapon->activeName;
        $this->activeDescription = $weapon->activeDescription;
        $this->activeValues = ValuesUtil::prepare($weapon->activeValues);
        $this->talents = $this->prepareTalents($weapon->talents);
        $this->patch = $weapon->patch;
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
                        $option['values'] = ValuesUtil::prepare($option['values']);
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

        $this->specialValues = ValuesUtil::clean($this->specialValues);
        $this->passiveValues = ValuesUtil::clean($this->passiveValues);
        $this->activeValues = ValuesUtil::clean($this->activeValues);

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
        $this->specialValues = ValuesUtil::add($this->specialValues);
    }

    public function deleteSpecial(int $index)
    {
        $this->specialValues = ValuesUtil::remove($this->specialValues, $index);
    }

    public function addPassiveValue()
    {
        $this->passiveValues = ValuesUtil::add($this->passiveValues);
    }

    public function deletePassive(int $index)
    {
        $this->passiveValues = ValuesUtil::remove($this->passiveValues, $index);
    }

    public function addActiveValue()
    {
        $this->activeValues = ValuesUtil::add($this->activeValues);
    }

    public function deleteActive(int $index)
    {
        $this->activeValues = ValuesUtil::remove($this->activeValues, $index);
    }

    public function addTalent(): void
    {
        assert(count($this->talents) < 5);
        $this->talents[] = ['id' => (string) Str::uuid(), 'name' => '', 'options' => []];
    }

    public function addOption(int $index): void
    {
        assert(count($this->talents[$index]['options']) < 5);
        $this->talents[$index]['options'][] = ['id' => (string) Str::uuid(), 'type' => WeaponTalentOptionType::CUSTOM, 'values' => []];
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
        $this->talents[$index]['options'][$optionIndex]['values'] = ValuesUtil::add($this->talents[$index]['options'][$optionIndex]['values']);
    }

    public function deleteOptionValue(int $index, int $optionIndex, int $valueIndex): void
    {
        $this->talents[$index]['options'][$optionIndex]['values'] = ValuesUtil::remove($this->talents[$index]['options'][$optionIndex]['values'], $valueIndex);
    }
}
