<?php

namespace App\Livewire\Forms\Admin\Misc;

use App\Enums\PerkType;
use App\Models\Perk;
use App\Rules\ContainsValuesRule;
use App\Utils\ValuesUtil;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PerksForm extends Form
{
    public ?Perk $perk = null;

    #[Validate('required')]
    public string $name = '';

    public PerkType $type = PerkType::ALACRITY;

    public string $effect = '';

    public array $values = [];

    public int $threshold = 0;

    public ?int $patch = null;

    public function rules()
    {
        return [
            'effect' => new ContainsValuesRule($this->values),
        ];
    }

    public function setPerk(Perk $perk)
    {
        $this->perk = $perk;

        $this->name = $perk->name;
        $this->type = $perk->type;
        $this->effect = $perk->effect;
        $this->values = ValuesUtil::prepare($perk->values);
        $this->threshold = $perk->threshold;
        $this->patch = $perk->patch;
    }

    public function store(): void
    {
        $this->validate();

        $this->values = ValuesUtil::clean($this->values);
        Perk::create($this->all());
    }

    public function update(): void
    {
        $this->validate();
        $this->values = ValuesUtil::clean($this->values);
        $this->perk->update($this->all());
    }

    public function addValue(): void
    {
        $this->values = ValuesUtil::add($this->values);
    }

    public function deleteValue(int $index): void
    {
        $this->values = ValuesUtil::remove($this->values, $index);
    }
}
